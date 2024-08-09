"user server";

import DataLayout from "@/Layouts/DataLayout";

import { columns } from "./Column";

import { Empresa } from "@/types";

interface Props {
  data: Empresa[];
  url: string;
}

export default function Table({ data, url }: Props) {
  const initVisibility = {
    nombre: true,
    nif: true,
    email: true,
    tel: true,
    perfil: true,
    codigo: true,
    ropo_capacitacion: false,
    ropo_caducidad: false,
    ropo_nro: false,
  };

  return (
    <DataLayout
      title="Empresas"
      data={data}
      columns={columns}
      url={url}
      initialVisibility={initVisibility}
    />
  );
}
