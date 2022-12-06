import { FunctionComponent, useState } from "react";
import Link from "next/link";
import { useRouter } from "next/router";
import { ErrorMessage, Formik } from "formik";
import { useMutation } from "react-query";

import { fetch, FetchError, FetchResponse } from "../../utils/dataAccess";
import { ValFoncier } from "../../types/ValFoncier";

interface Props {
  valfoncier?: ValFoncier;
}

interface SaveParams {
  values: ValFoncier;
}

interface DeleteParams {
  id: string;
}

const saveValFoncier = async ({ values }: SaveParams) =>
  await fetch<ValFoncier>(!values["@id"] ? "/val_fonciers" : values["@id"], {
    method: !values["@id"] ? "POST" : "PUT",
    body: JSON.stringify(values),
  });

const deleteValFoncier = async (id: string) =>
  await fetch<ValFoncier>(id, { method: "DELETE" });

export const Form: FunctionComponent<Props> = ({ valfoncier }) => {
  const [, setError] = useState<string | null>(null);
  const router = useRouter();

  const saveMutation = useMutation<
    FetchResponse<ValFoncier> | undefined,
    Error | FetchError,
    SaveParams
  >((saveParams) => saveValFoncier(saveParams));

  const deleteMutation = useMutation<
    FetchResponse<ValFoncier> | undefined,
    Error | FetchError,
    DeleteParams
  >(({ id }) => deleteValFoncier(id), {
    onSuccess: () => {
      router.push("/valfonciers");
    },
    onError: (error) => {
      setError(`Error when deleting the resource: ${error}`);
      console.error(error);
    },
  });

  const handleDelete = () => {
    if (!valfoncier || !valfoncier["@id"]) return;
    if (!window.confirm("Are you sure you want to delete this item?")) return;
    deleteMutation.mutate({ id: valfoncier["@id"] });
  };

  return (
    <div>
      <h1>
        {valfoncier
          ? `Edit ValFoncier ${valfoncier["@id"]}`
          : `Create ValFoncier`}
      </h1>
      <Formik
        initialValues={
          valfoncier
            ? {
                ...valfoncier,
              }
            : new ValFoncier()
        }
        validate={() => {
          const errors = {};
          // add your validation logic here
          return errors;
        }}
        onSubmit={(values, { setSubmitting, setStatus, setErrors }) => {
          const isCreation = !values["@id"];
          saveMutation.mutate(
            { values },
            {
              onSuccess: () => {
                setStatus({
                  isValid: true,
                  msg: `Element ${isCreation ? "created" : "updated"}.`,
                });
                router.push("/val_fonciers");
              },
              onError: (error) => {
                setStatus({
                  isValid: false,
                  msg: `${error.message}`,
                });
                if ("fields" in error) {
                  setErrors(error.fields);
                }
              },
              onSettled: () => {
                setSubmitting(false);
              },
            }
          );
        }}
      >
        {({
          values,
          status,
          errors,
          touched,
          handleChange,
          handleBlur,
          handleSubmit,
          isSubmitting,
        }) => (
          <form onSubmit={handleSubmit}>
            <div className="form-group">
              <label
                className="form-control-label"
                htmlFor="valfoncier_dateAquisition"
              >
                dateAquisition
              </label>
              <input
                name="dateAquisition"
                id="valfoncier_dateAquisition"
                value={values.dateAquisition?.toLocaleString() ?? ""}
                type="dateTime"
                placeholder=""
                className={`form-control${
                  errors.dateAquisition && touched.dateAquisition
                    ? " is-invalid"
                    : ""
                }`}
                aria-invalid={
                  errors.dateAquisition && touched.dateAquisition
                    ? "true"
                    : undefined
                }
                onChange={handleChange}
                onBlur={handleBlur}
              />
              <ErrorMessage
                className="invalid-feedback"
                component="div"
                name="dateAquisition"
              />
            </div>
            <div className="form-group">
              <label className="form-control-label" htmlFor="valfoncier_type">
                type
              </label>
              <input
                name="type"
                id="valfoncier_type"
                value={values.type ?? ""}
                type="text"
                placeholder=""
                className={`form-control${
                  errors.type && touched.type ? " is-invalid" : ""
                }`}
                aria-invalid={errors.type && touched.type ? "true" : undefined}
                onChange={handleChange}
                onBlur={handleBlur}
              />
              <ErrorMessage
                className="invalid-feedback"
                component="div"
                name="type"
              />
            </div>
            <div className="form-group">
              <label
                className="form-control-label"
                htmlFor="valfoncier_codePostal"
              >
                codePostal
              </label>
              <input
                name="codePostal"
                id="valfoncier_codePostal"
                value={values.codePostal ?? ""}
                type="text"
                placeholder=""
                required={true}
                className={`form-control${
                  errors.codePostal && touched.codePostal ? " is-invalid" : ""
                }`}
                aria-invalid={
                  errors.codePostal && touched.codePostal ? "true" : undefined
                }
                onChange={handleChange}
                onBlur={handleBlur}
              />
              <ErrorMessage
                className="invalid-feedback"
                component="div"
                name="codePostal"
              />
            </div>
            <div className="form-group">
              <label
                className="form-control-label"
                htmlFor="valfoncier_surface"
              >
                surface
              </label>
              <input
                name="surface"
                id="valfoncier_surface"
                value={values.surface ?? ""}
                type="number"
                step="0.1"
                placeholder=""
                className={`form-control${
                  errors.surface && touched.surface ? " is-invalid" : ""
                }`}
                aria-invalid={
                  errors.surface && touched.surface ? "true" : undefined
                }
                onChange={handleChange}
                onBlur={handleBlur}
              />
              <ErrorMessage
                className="invalid-feedback"
                component="div"
                name="surface"
              />
            </div>
            <div className="form-group">
              <label className="form-control-label" htmlFor="valfoncier_prix">
                prix
              </label>
              <input
                name="prix"
                id="valfoncier_prix"
                value={values.prix ?? ""}
                type="number"
                step="0.1"
                placeholder=""
                className={`form-control${
                  errors.prix && touched.prix ? " is-invalid" : ""
                }`}
                aria-invalid={errors.prix && touched.prix ? "true" : undefined}
                onChange={handleChange}
                onBlur={handleBlur}
              />
              <ErrorMessage
                className="invalid-feedback"
                component="div"
                name="prix"
              />
            </div>
            {status && status.msg && (
              <div
                className={`alert ${
                  status.isValid ? "alert-success" : "alert-danger"
                }`}
                role="alert"
              >
                {status.msg}
              </div>
            )}
            <button
              type="submit"
              className="btn btn-success"
              disabled={isSubmitting}
            >
              Submit
            </button>
          </form>
        )}
      </Formik>
      <Link href="/valfonciers">
        <a className="btn btn-primary">Back to list</a>
      </Link>
      {valfoncier && (
        <button className="btn btn-danger" onClick={handleDelete}>
          <a>Delete</a>
        </button>
      )}
    </div>
  );
};
