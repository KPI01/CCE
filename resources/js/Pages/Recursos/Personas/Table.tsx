"user server";

import DataLayout from "@/Layouts/DataLayout";

import { columns } from "./Column";

import { Persona } from "@/types";
import { InitialTableState } from "@tanstack/react-table";

interface Props {
  data: Persona[];
}

const RECURSO = "personas";

export default function Page({ data }: Props) {
  const initVisibility = {
    nombres: true,
    apellidos: true,
    id_nac: true,
    email: true,
    tel: true,
    perfil: true,
    ropo_tipo: false,
    ropo_caducidad: false,
    ropo_nro: false,
    ropo_tipo_aplicador: false,
  };

  return (
    <DataLayout
      title="Personas"
      data={data}
      columns={columns}
      recurso={RECURSO}
      initialVisibility={initVisibility}
    />
  );
}
