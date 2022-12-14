import { FunctionComponent } from "react";
import Link from "next/link";

import ReferenceLinks from "../common/ReferenceLinks";
import { getPath } from "../../utils/dataAccess";
import { ValFoncier } from "../../types/ValFoncier";

interface Props {
  valfonciers: ValFoncier[];
}

export const List: FunctionComponent<Props> = ({ valfonciers }) => (
  <div>
    <h1 className="text-3xl font-bold underline">ValFoncier List</h1>
    <br/>
    <Link href="/valfonciers/create">
      <a className="m-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm pr-5 pl-5 pt-2.5 pb-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Create</a>
    </Link>
    <br/>
    <br/>
    <div className="mb-4 overflow-x-auto relative shadow-md sm:rounded-lg m-1">
      <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" className="py-3 px-6" >id</th>
          <th scope="col" className="py-3 px-6" >dateAquisition</th>
          <th scope="col" className="py-3 px-6" >type</th>
          <th scope="col" className="py-3 px-6" >codePostal</th>
          <th scope="col" className="py-3 px-6" >surface</th>
          <th scope="col" className="py-3 px-6" >prix</th>
          <th scope="col" colSpan={2} className="py-3 px-6" >actions</th>
        </tr>
        </thead>
        <tbody>
        {valfonciers &&
          valfonciers.length !== 0 &&
          valfonciers.map(
            (valfoncier) =>
              valfoncier["@id"] && (
                <tr className="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600" key={valfoncier["@id"]}>
                  <th scope="row" className="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <ReferenceLinks
                      items={{
                        href: getPath(valfoncier["@id"], "/valfonciers/[id]"),
                        name: valfoncier["@id"],
                      }}
                    />
                  </th>
                  <td scope="col" className="py-4 px-6">{valfoncier["dateAquisition"]?.toLocaleString()}</td>
                  <td scope="col" className="py-4 px-6">{valfoncier["type"]}</td>
                  <td scope="col" className="py-4 px-6">{valfoncier["codePostal"]}</td>
                  <td scope="col" className="py-4 px-6">{valfoncier["surface"]}</td>
                  <td scope="col" className="py-4 px-6">{valfoncier["prix"]}</td>
                  <td scope="col" className="py-4 px-6">
                    <Link
                      href={getPath(valfoncier["@id"], "/valfonciers/[id]")}
                    >
                      <a className="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        <span>Show</span>
                      </a>
                    </Link>
                  </td>
                  <td scope="col" className="py-4 px-6">
                    <Link
                      href={getPath(
                        valfoncier["@id"],
                        "/valfonciers/[id]/edit"
                      )}
                    >
                      <a className="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                        <svg className="w-6 h-6"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                          <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span>Edit</span>
                      </a>
                    </Link>
                  </td>
                </tr>
              )
          )}
        </tbody>
      </table>
    </div>
  </div>
);
