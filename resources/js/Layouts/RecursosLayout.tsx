import { Head } from "@inertiajs/react";

import MainLayout from "@/Layouts/MainLayout";
import { LayoutProps, UUID } from "@/types";
import FormHeader from "@/Components/Forms/FormHeader";

export default function RecursosLayout({
  children,
  pageTitle,
  mainTitle,
  created_at,
  updated_at,
  recurso,
  urls,
  action,
  id,
}: LayoutProps & { id?: UUID }) {
  return (
    <MainLayout>
      <Head title={pageTitle} />
      <FormHeader
        id={id}
        title={mainTitle}
        created={created_at}
        updated={updated_at}
        recurso={recurso}
        urls={urls}
        action={action}
        className="mb-6"
      />
      {children}
    </MainLayout>
  );
}
