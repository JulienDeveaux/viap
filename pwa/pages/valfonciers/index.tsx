import { GetServerSideProps, NextComponentType, NextPageContext } from "next";
import Head from "next/head";
import { dehydrate, QueryClient, useQuery } from "react-query";

import Pagination from "../../components/common/Pagination";
import { List } from "../../components/valfoncier/List";
import { PagedCollection } from "../../types/collection";
import { ValFoncier } from "../../types/ValFoncier";
import { fetch, FetchResponse } from "../../utils/dataAccess";
import { useMercure } from "../../utils/mercure";

const getValFonciers = async () =>
  await fetch<PagedCollection<ValFoncier>>("/val_fonciers");

const Page: NextComponentType<NextPageContext> = () => {
  const { data: { data: valfonciers, hubURL } = { hubURL: null } } = useQuery<
    FetchResponse<PagedCollection<ValFoncier>> | undefined
  >("val_fonciers", getValFonciers);
  const collection = useMercure(valfonciers, hubURL);

  if (!collection || !collection["hydra:member"]) return null;

  return (
    <div className="p-2">
      <div>
        <Head>
          <title>ValFoncier List</title>
        </Head>
      </div>
      <List valfonciers={collection["hydra:member"]} />
      <Pagination collection={collection} />
    </div>
  );
};

export const getServerSideProps: GetServerSideProps = async () => {
  const queryClient = new QueryClient();
  await queryClient.prefetchQuery("val_fonciers", getValFonciers);

  return {
    props: {
      dehydratedState: dehydrate(queryClient),
    },
  };
};

export default Page;
