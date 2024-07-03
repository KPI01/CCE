"user server";

import DataLayout from "@/Layouts/DataLayout";

import { columns } from "./Column";

import { RECURSO } from "./formSchema";

import { Empresa } from "@/types";

interface Props {
  data: Empresa[];
}

interface ropoVisibility {
  ropo_tipo: boolean;
  ropo_caducidad: boolean;
  ropo_nro: boolean;
  ropo_tipo_aplicador: boolean;
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
    codigo: false,
    ropo_tipo: false,
    ropo_caducidad: false,
    ropo_nro: false,
    ropo_tipo_aplicador: false,
  };

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
