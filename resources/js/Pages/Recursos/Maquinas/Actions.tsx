import RowActions from "@/Components/DataTable/RowActions";
import { Maquina } from "@/types";

export default function Actions({ data }: { data: Maquina }) {
  return (
    <RowActions
      id={data.id}
      urls={data.urls}
      info={{
        id: data.matricula,
        nombre: data.nombre,
      }}
    />
  );
}
