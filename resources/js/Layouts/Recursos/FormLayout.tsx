import { Head } from "@inertiajs/react";

import MainLayout from "@/Layouts/MainLayout";
import { LayoutProps } from "@/types";
import FormHeader from "@/Components/Forms/FormHeader";

interface Props extends Omit<LayoutProps, "created_at" | "updated_at"> {
  created_at: string;
  updated_at: string;
  backUrl: string;
}

export default function FormLayout({
  children,
  pageTitle,
  mainTitle,
  created_at,
  updated_at,
  urls,
  id,
  backUrl
}: Props) {
  return (
    <MainLayout>
      <Head title={pageTitle} />
      <FormHeader
        id={id}
        title={mainTitle}
        created_at={new Date(created_at)}
        updated_at={new Date(updated_at)}
        urls={urls}
        className="mb-6"
        backUrl={backUrl}
      />
      {children}
    </MainLayout>
  );
}
