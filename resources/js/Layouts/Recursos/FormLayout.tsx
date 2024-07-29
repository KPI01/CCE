import { Head } from "@inertiajs/react";

import MainLayout from "@/Layouts/MainLayout";
import { LayoutProps } from "@/types";
import FormHeader from "@/Components/Forms/FormHeader";

export default function FormLayout({
  children,
  pageTitle,
  mainTitle,
  created_at,
  updated_at,
  urls,
  id,
}: LayoutProps & { backUrl?: string }) {
  return (
    <MainLayout>
      <Head title={pageTitle} />
      <FormHeader
        id={id}
        title={mainTitle}
        created_at={created_at}
        updated_at={updated_at}
        urls={urls}
        className="mb-6"
      />
      {children}
    </MainLayout>
  );
}
