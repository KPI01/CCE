import { RowActions } from "@/Components/DataTable/RowActions";
import { Campana } from "@/types";

export default function Actions({ data }: { data: Campana }) {
  return (
    <RowActions
      id={data.id}
      url={data.url}
      info={{
        nombre: data.nombre,
      }}
    />
  );
}
