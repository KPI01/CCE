import { Head } from "@inertiajs/react";

import MainLayout from "@/Layouts/MainLayout";
import { LayoutProps, UUID } from "@/types";
import FormHeader from "@/Components/Forms/FormHeader";

export default function FormLayout({
  children,
  pageTitle,
  mainTitle,
  created_at,
  updated_at,
  urls,
  backUrl
}: LayoutProps & {backUrl?: string}) {
  return (
    <MainLayout>
      <Head title={pageTitle} />
      <FormHeader
        title={mainTitle}
        created={created_at}
        updated={updated_at}
        urls={urls}
        backUrl={backUrl}
        className="mb-6"
      />
      {children}
    </MainLayout>
  );
}
