import { Head } from "@inertiajs/react";

import MainLayout from "@/Layouts/MainLayout";
import { LayoutProps } from "@/types";
import FormHeader from "@/Components/Forms/FormHeader";

interface Props extends Omit<LayoutProps, "created_at" | "updated_at"> {
  created_at?: string;
  updated_at?: string;
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
  backUrl,
}: Props) {
  let auxCreatedAt: string | Date | null;
  let auxUpdatedAt: string | Date | null;

  auxCreatedAt = created_at ?? null;
  auxUpdatedAt = updated_at ?? null;

  if (auxCreatedAt !== null) {
    auxCreatedAt = new Date(auxCreatedAt);
  }
  if (auxUpdatedAt !== null) {
    auxUpdatedAt = new Date(auxUpdatedAt);
  }

  return (
    <MainLayout id={id}>
      <Head title={pageTitle} />
      <FormHeader
        id={id}
        title={mainTitle}
        created_at={auxCreatedAt}
        updated_at={auxUpdatedAt}
        urls={urls}
        className="mb-6"
        backUrl={backUrl}
      />
      {children}
    </MainLayout>
  );
}
