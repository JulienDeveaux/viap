import { FunctionComponent, useState } from "react";
import Link from "next/link";
import { useRouter } from "next/router";
import Head from "next/head";

import { fetch, getPath } from "../../utils/dataAccess";
import { ValFoncier } from "../../types/ValFoncier";

interface Props {
  valfoncier: ValFoncier;
  text: string;
}

export const Show: FunctionComponent<Props> = ({ valfoncier, text }) => {
  const [error, setError] = useState<string | null>(null);
  const router = useRouter();

  const handleDelete = async () => {
    if (!valfoncier["@id"]) return;
    if (!window.confirm("Are you sure you want to delete this item?")) return;

    try {
      await fetch(valfoncier["@id"], { method: "DELETE" });
      router.push("/valfonciers");
    } catch (error) {
      setError("Error when deleting the resource.");
      console.error(error);
    }
  };

  return (
    <div>
      <Head>
        <title>{`Show ValFoncier ${valfoncier["@id"]}`}</title>
        <script
          type="application/ld+json"
          dangerouslySetInnerHTML={{ __html: text }}
        />
      </Head>
      <h1>{`Show ValFoncier ${valfoncier["@id"]}`}</h1>
      <table className="table table-responsive table-striped table-hover">
        <thead>
          <tr>
            <th>Field</th>
            <th>Value</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">dateAquisition</th>
            <td>{valfoncier["dateAquisition"]?.toLocaleString()}</td>
          </tr>
          <tr>
            <th scope="row">type</th>
            <td>{valfoncier["type"]}</td>
          </tr>
          <tr>
            <th scope="row">codePostal</th>
            <td>{valfoncier["codePostal"]}</td>
          </tr>
          <tr>
            <th scope="row">surface</th>
            <td>{valfoncier["surface"]}</td>
          </tr>
          <tr>
            <th scope="row">prix</th>
            <td>{valfoncier["prix"]}</td>
          </tr>
        </tbody>
      </table>
      {error && (
        <div className="alert alert-danger" role="alert">
          {error}
        </div>
      )}
      <Link href="/valfonciers">
        <a className="btn btn-primary">Back to list</a>
      </Link>{" "}
      <Link href={getPath(valfoncier["@id"], "/valfonciers/[id]/edit")}>
        <a className="btn btn-warning">Edit</a>
      </Link>
      <button className="btn btn-danger" onClick={handleDelete}>
        Delete
      </button>
    </div>
  );
};
