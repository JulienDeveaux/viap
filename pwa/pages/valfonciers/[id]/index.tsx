import {
  GetStaticPaths,
  GetStaticProps,
  NextComponentType,
  NextPageContext,
} from "next";
import DefaultErrorPage from "next/error";
import Head from "next/head";
import { useRouter } from "next/router";
import { dehydrate, QueryClient, useQuery } from "react-query";

import { Show } from "../../../components/valfoncier/Show";
import { PagedCollection } from "../../../types/collection";
import { ValFoncier } from "../../../types/ValFoncier";
import { fetch, FetchResponse, getPaths } from "../../../utils/dataAccess";
import { useMercure } from "../../../utils/mercure";

const getValFoncier = async (id: string | string[] | undefined) =>
  id
    ? await fetch<ValFoncier>(`/val_fonciers/${id}`)
    : Promise.resolve(undefined);

const Page: NextComponentType<NextPageContext> = () => {
  const router = useRouter();
  const { id } = router.query;

  const {
    data: { data: valfoncier, hubURL, text } = { hubURL: null, text: "" },
  } = useQuery<FetchResponse<ValFoncier> | undefined>(["valfoncier", id], () =>
    getValFoncier(id)
  );
  const valfoncierData = useMercure(valfoncier, hubURL);

  if (!valfoncierData) {
    return <DefaultErrorPage statusCode={404} />;
  }

  return (
    <div>
      <div>
        <Head>
          <title>{`Show ValFoncier ${valfoncierData["@id"]}`}</title>
        </Head>
      </div>
      <Show valfoncier={valfoncierData} text={text} />
    </div>
  );
};

export const getStaticProps: GetStaticProps = async ({
  params: { id } = {},
}) => {
  if (!id) throw new Error("id not in query param");
  const queryClient = new QueryClient();
  await queryClient.prefetchQuery(["valfoncier", id], () => getValFoncier(id));

  return {
    props: {
      dehydratedState: dehydrate(queryClient),
    },
    revalidate: 1,
  };
};

export const getStaticPaths: GetStaticPaths = async () => {
  const response = await fetch<PagedCollection<ValFoncier>>("/val_fonciers");
  const paths = await getPaths(response, "val_fonciers", "/valfonciers/[id]");

  return {
    paths,
    fallback: true,
  };
};

export default Page;
