import { RowActions } from "@/Components/DataTable/RowActions";
import { Empresa } from "@/types";

export default function Actions({ data }: { data: Empresa }) {
  return (
    <RowActions
      id={data.id}
      url={data.url}
      info={{
        id: data.nif,
        nombre: data.nombre,
      }}
    />
  );
}
