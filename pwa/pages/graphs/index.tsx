import {NextComponentType, NextPageContext} from "next";
import Head from "next/head";
import {fetch} from "../../utils/dataAccess";
import {GraphOperation} from "../../types/GraphOperation";
import {useQuery} from "react-query";
import React, {useState} from "react";
import {LineChart, BarChart} from "react-d3-components";

import * as d3 from "d3";

const getTimeSeries = async (years: number[]) => await fetch<GraphOperation>('/grapOperation/prix_moyen', {
  method: 'POST',
  body: JSON.stringify({
    years: years
  })
});

const getCountPeriod = async (period: number, startDate: Date, endDate: Date) => await fetch('/grapOperation/count_period', {
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
      <select
        multiple={true}
        className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        onChange={(e) => setYears(Array.from(e.target.selectedOptions, option => parseInt(option.value)))}>
        <option value="2018">2018</option>
        <option value="2019">2019</option>
        <option value="2020">2020</option>
        <option value="2021">2021</option>
      </select>
      <button
        className="mt-2 text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
        onClick={async () => setSeries((await getTimeSeries(years))?.data.prixM2 || [])}
      >Soumettre</button>

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

        <select
          className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
          onChange={(e) => setPeriodNb(parseInt(e.target.selectedOptions[0].value))}>
          <option value={0}>Jours</option>
          <option value={1}>Semaine</option>
          <option value={2}>mois</option>
          <option value={3}>année</option>
        </select>


        <label >Start date: </label>
        <input type="date" onChange={(e) => console.log(e.target.value)} />

        <label>End date: </label>
        <input type="date" onChange={(e) => setEndPeriod(e.target.value)} />

        <button
          className="mt-2 text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
          onClick={async () => setPeriodData(await getCountPeriod(periodNb, startPeriod, endPeriod))}
        >Soummettre</button>

      {countPeriodData && <BarChart

      />}
    </React.Fragment>

    return (
        <div className="p-3">
            <Head>
              {/*ajoute les balise dans le head de la page dynamiquement*/}
              <title>Graphs</title>
            </Head>
            <select
              className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              onChange={(e) => setGraph(e.target.selectedOptions[0].value)}>
              <option value={0}>prix m²</option>
              <option value={1}>Nombre de vente</option>
              <option value={2}>Répartition des ventes</option>
            </select>

          {typeGraph == 0 ? graphPrixMcarre() : typeGraph == 1 ? graphNbVente() : ""}
        </div>
    );
};

export default Page;
