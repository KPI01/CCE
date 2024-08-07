import RowActions from "@/Components/DataTable/RowActions";
import { Persona } from "@/types";

export default function Actions({ data }: { data: Persona }) {
  return (
    <RowActions
      id={data.id}
      url={data.url}
      info={{
        id: data.id_nac,
        nombre: [data.nombres, data.apellidos],
      }}
    />
  );
}
