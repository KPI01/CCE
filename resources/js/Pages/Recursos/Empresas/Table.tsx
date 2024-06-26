"user server";

import DataLayout from "@/Layouts/DataLayout";

import { columns } from "./Column";

import { Empresa } from "@/types";

interface Props {
  data: Empresa[];
  isAdmin: boolean;
}

export default function Table(props: Props) {
  return (
    <DataLayout
      title="Empresas"
      isAdmin={props.isAdmin}
      data={props.data}
      columns={columns}
      recurso="empresa"
    />
  );
}
