import SimpleTable from "@/Components/Table/SimpleTable";
import MainLayout from "./MainLayout";
import { Data, LayoutProps } from "@/types";
import { Head } from "@inertiajs/react";
import MainTitle from "@/Components/Layouts/MainTitle";

interface Props extends Omit<LayoutProps, "urls"> {
  data: { cols: string[]; values: Data[] };
  url: string;
}

export default function TableLayout({ data, pageTitle, mainTitle }: Props) {
  let { cols, values } = data;

  cols = cols.map((col) => {
    if (col === "urls") {
      return (col = "Acciones");
    }
  });

  return (
    <MainLayout>
      <Head title={pageTitle} />
      <div className="mt-10">
        <MainTitle title={mainTitle} />
        <SimpleTable {...data} />
      </div>
    </MainLayout>
  );
}
