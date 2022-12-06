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
    <h1>ValFoncier List</h1>
    <Link href="/valfonciers/create">
      <a className="btn btn-primary">Create</a>
    </Link>
    <table className="table table-responsive table-striped table-hover">
      <thead>
        <tr>
          <th>id</th>
          <th>dateAquisition</th>
          <th>type</th>
          <th>codePostal</th>
          <th>surface</th>
          <th>prix</th>
          <th />
        </tr>
      </thead>
      <tbody>
        {valfonciers &&
          valfonciers.length !== 0 &&
          valfonciers.map(
            (valfoncier) =>
              valfoncier["@id"] && (
                <tr key={valfoncier["@id"]}>
                  <th scope="row">
                    <ReferenceLinks
                      items={{
                        href: getPath(valfoncier["@id"], "/valfonciers/[id]"),
                        name: valfoncier["@id"],
                      }}
                    />
                  </th>
                  <td>{valfoncier["dateAquisition"]?.toLocaleString()}</td>
                  <td>{valfoncier["type"]}</td>
                  <td>{valfoncier["codePostal"]}</td>
                  <td>{valfoncier["surface"]}</td>
                  <td>{valfoncier["prix"]}</td>
                  <td>
                    <Link
                      href={getPath(valfoncier["@id"], "/valfonciers/[id]")}
                    >
                      <a>
                        <i className="bi bi-search" aria-hidden="true"></i>
                        <span className="sr-only">Show</span>
                      </a>
                    </Link>
                  </td>
                  <td>
                    <Link
                      href={getPath(
                        valfoncier["@id"],
                        "/valfonciers/[id]/edit"
                      )}
                    >
                      <a>
                        <i className="bi bi-pen" aria-hidden="true" />
                        <span className="sr-only">Edit</span>
                      </a>
                    </Link>
                  </td>
                </tr>
              )
          )}
      </tbody>
    </table>
  </div>
);
