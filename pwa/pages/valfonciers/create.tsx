import { NextComponentType, NextPageContext } from "next";
import Head from "next/head";

import { Form } from "../../components/valfoncier/Form";

const Page: NextComponentType<NextPageContext> = () => (
  <div>
    <div>
      <Head>
        <title>Create ValFoncier</title>
      </Head>
    </div>
    <Form />
  </div>
);

export default Page;
