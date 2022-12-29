import {NextComponentType, NextPageContext} from "next";
import Head from "next/head";
import {fetch} from "../../utils/dataAccess";
import {GraphOperation} from "../../types/GraphOperation";
import {useQuery} from "react-query";
import React, {useState} from "react";
import {LineChart, BarChart} from "react-d3-components";
import {Select, Button} from "flowbite-react";

import * as d3 from "d3";
import {CountPeriodData} from "../../types/countPeriodData";

const getTimeSeries = async (years: number[]) => await fetch<GraphOperation>('/grapOperation/prix_moyen', {
  method: 'POST',
  body: JSON.stringify({
    years: years
  })
});

const getCountPeriod = async (period: number, startDate: Date, endDate: Date) => await fetch<CountPeriodData>('/graphOperation/count_period', {
  method: 'POST',
  body: JSON.stringify({
    period: period,
    startPeriod: startDate,
    endPeriod: endDate
  })
})

const Page: NextComponentType<NextPageContext> = () =>
{
    const [typeGraph, setGraph] = useState<number>(0);

    const [series, setSeries] = useState<any>([]);
    const [years, setYears] = useState<number[]>([]);

    const [periodNb, setPeriodNb] = useState<number>(0);
    const [startPeriod, setStartPeriod] = useState<Date>(new Date(Date.now()));
    const [endPeriod, setEndPeriod] = useState<Date>(new Date(new Date(Date.now()).setDate(startPeriod.getDate() + 1)));
    const [countPeriodData, setPeriodData] = useState<any>(undefined);

    const datas: any = {};

    for (const s of series)
        datas[Object.keys(s)[0]] = s[Object.keys(s)[0]];

    const graphPrixMcarre = () => <React.Fragment>
      <h1 className="text-3xl font-bold underline">Prix moyen du m2</h1>

      <label className="block mb-2 text-sm font-medium text-dark">Années:</label>
      <Select
        multiple={true}
        onChange={(e: any) => setYears(Array.from(e.target.selectedOptions, option => parseInt(option.value)))}>
        <option value="2018">2018</option>
        <option value="2019">2019</option>
        <option value="2020">2020</option>
        <option value="2021">2021</option>
      </Select>
      <Button
        onClick={async () => setSeries((await getTimeSeries(years))?.data.prixM2 || [])}
      >Soumettre</Button>

      {/*https://github.com/codesuki/react-d3-components#documentation*/}
      {series.length > 0 && <LineChart
        width={500}
        height={400}
        data={{
          label: Object.keys(datas),
          values: Object.keys(datas).map(key => ({x: new Date(Number(key), 1, 1), y: parseFloat(datas[key])}))
        }}
        tooltipHtml={(_: any, {x, y}: any) => `${x.getFullYear()}: ${y} €`}
        margin={{top: 10, bottom: 50, left: 100, right: 10}}
        xAxis={{
          label: "Années",
          tickFormat: (x: any) => { return x.getFullYear(); },
          tickArguments: [Object.keys(datas).length],
        }}
        yAxis={{
          label: "prix (€)",
          tickFormat: (x: any) => { return x; },
        }}
      />}
    </React.Fragment>

    const graphNbVente = () => <React.Fragment>
        <h1 className="text-3xl font-bold underline">Nombre de ventes</h1>

        <Select
          onChange={(e: any) => setPeriodNb(parseInt(e.target.selectedOptions[0].value))}>
          <option value={0}>Jours</option>
          <option value={1}>Semaine</option>
          <option value={2}>mois</option>
          <option value={3}>année</option>
        </Select>


        <label >Start date: </label>
        <input className="form-control" type="date" onChange={(e) => setStartPeriod(new Date(Date.parse(e.target.value)))} />
        <br/>
        <label>End date: </label>
        <input className="form-control" type="date" onChange={(e) => setEndPeriod(new Date(Date.parse(e.target.value)))} />
        <br/>
        <Button
          onClick={async () => setPeriodData((await getCountPeriod(periodNb, startPeriod, endPeriod))?.data.periods)}
        >Soummettre</Button>

      {countPeriodData && Object.keys(countPeriodData).length > 0 && <BarChart
        width={window.innerWidth}
        height={400}
        className={"text-white"}
        margin={{top: 10, bottom: 50, left: 100, right: 10}}
        data={{
          labels: Object.keys(countPeriodData),
          values: Object.keys(countPeriodData).map(key => ({x: key, y: countPeriodData[key]}))
        }}
        yAxis={{
          label: "nombre de vente"
        }}
        xAxis={{
          label: "Periodes (" + (periodNb == 0 ? "jours" : periodNb == 1 ? "semaines" : periodNb == 2 ? "mois" : "années") + ")",
          tickArguments: [Object.keys(countPeriodData).length],
        }}
        tooltipHtml={(x: any) => `${x}: ${parseInt(countPeriodData[x]).toLocaleString()}`}
      />}
    </React.Fragment>

    return (
        <div className="p-3">
            <Head>
              {/*ajoute les balise dans le head de la page dynamiquement*/}
              <title>Graphs</title>
            </Head>
            <Select
              onChange={(e: any) => setGraph(e.target.selectedOptions[0].value)}>
              <option value={0}>prix m²</option>
              <option value={1}>Nombre de vente</option>
              <option value={2}>Répartition des ventes</option>
            </Select>

          {typeGraph == 0 ? graphPrixMcarre() : typeGraph == 1 ? graphNbVente() : ""}
        </div>
    );
};

export default Page;
