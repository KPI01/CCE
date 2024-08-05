import { Head, Link } from "@inertiajs/react";

import MainLayout from "@/Layouts/MainLayout";
import { Breadcrumbs, LayoutProps } from "@/types";
import FormHeader from "@/Components/Forms/FormHeader";
import {
  Breadcrumb,
  BreadcrumbItem,
  BreadcrumbLink,
  BreadcrumbList,
  BreadcrumbPage,
  BreadcrumbSeparator,
} from "@/Components/ui/breadcrumb";
import { v4 as uuidv4 } from "uuid";
import { Slash } from "lucide-react";

interface Props {
  created_at?: string;
  updated_at?: string;
  breadcrumbs: Breadcrumbs[];
  showActions?: boolean;
}

export default function FormLayout({
  children,
  pageTitle,
  mainTitle,
  created_at,
  updated_at,
  urls,
  id,
  breadcrumbs,
  showActions = true,
}: Props & Omit<LayoutProps, "created_at" | "updated_at">) {
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
    <MainLayout>
      <Head title={pageTitle} />
      <Breadcrumb className="mt-4">
        <BreadcrumbList>
          {breadcrumbs.map((item) => {
            console.debug("item:", item);
            const currentRoute = route().current();
            let currentUrl;

            if (currentRoute) {
              console.debug("currentRoute:", currentRoute);
              const action = currentRoute.split(".")[1];
              if (["index", "create"].includes(action)) {
                currentUrl = route(currentRoute);
              } else {
                console.debug("la ruta necesita id");
                currentUrl = route(currentRoute, id);
              }

              const itemIsCurrent = item.url === currentUrl;

              const itemComponent = itemIsCurrent ? (
                <BreadcrumbPage>{item.text}</BreadcrumbPage>
              ) : (
                <BreadcrumbLink asChild>
                  <Link href={item.url}>{item.text}</Link>
                </BreadcrumbLink>
              );
              const separator = itemIsCurrent ? (
                " "
              ) : (
                <BreadcrumbSeparator>
                  <Slash />
                </BreadcrumbSeparator>
              );

              return (
                <span className="flex items-center gap-3" key={uuidv4()}>
                  <BreadcrumbItem>{itemComponent}</BreadcrumbItem>
                  {separator}
                </span>
              );
            }
          })}
        </BreadcrumbList>
      </Breadcrumb>
      <FormHeader
        id={id}
        title={mainTitle}
        created_at={auxCreatedAt}
        updated_at={auxUpdatedAt}
        className="mb-6"
        urls={urls}
        showActions={showActions}
      />
      {children}
    </MainLayout>
  );
}
