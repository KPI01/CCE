"user server";

import DataLayout from "@/Layouts/DataLayout";

import { columns } from "./Column";

import { RECURSO } from "./formSchema";

import { Empresa } from "@/types";

interface Props {
  data: Empresa[];
}

interface ropoVisibility {
  ropo_capacitacion: boolean;
  ropo_caducidad: boolean;
  ropo_nro: boolean;
}
export default function Table({ data }: Props) {
  const initVisibility: Record<
    keyof Omit<
      Empresa,
      | "ropo"
      | "observaciones"
      | "direccion"
      | "id"
      | "created_at"
      | "updated_at"
    >,
    Boolean
  > &
    ropoVisibility = {
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

  console.debug(data);

  return (
    <DataLayout
      title="Empresas"
      data={data}
      columns={columns}
      recurso={RECURSO}
      initialVisibility={initVisibility}
    />
  );
}
