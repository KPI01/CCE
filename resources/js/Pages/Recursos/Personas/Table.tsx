"user server";

import DataLayout from "@/Layouts/DataLayout";

import { columns } from "./Column";

import { Persona } from "@/types";
import { RECURSO } from "./formSchema";

export default function Table({ data }: { data: Persona[] }) {
  const initVisibility = {
    nombres: true,
    apellidos: true,
    id_nac: true,
    email: true,
    tel: true,
    perfil: true,
    ropo_capacitacion: false,
    ropo_caducidad: false,
    ropo_nro: false,
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
