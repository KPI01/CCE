import { DataTableColumnHeader } from "@/Components/DataTable/ColumnHeader";
import { RowActionsLiveEdit } from "@/Components/DataTable/RowActions";
import { ColumnDef } from "@tanstack/react-table";
import { v4 as uuid } from "uuid";

export function createColumn(
  data: Record<string, unknown> & {
    id?: number;
    url?: string;
    nombre?: string;
  },
  avoid: string[] = [],
) {
  let column: ColumnDef<typeof data>[] = [];

  if (!data) {
    return null;
  }

  const keys: string[] = Object.keys(data);
  console.debug(keys, keys.length);

  for (const key of keys) {
    const keyIsAcciones = key === "url";
    console.debug(key, `key is url?`, keyIsAcciones);
    const size = keys.indexOf(key) + 1;
    console.debug(size, keys.length - 2, size / (keys.length - 1));
    const title = !keyIsAcciones
      ? `${key.charAt(0).toUpperCase()}${key.slice(1)}`
      : "Acciones";

    if (!avoid.includes(key)) {
      column.push({
        id: key,
        accessorKey: key,
        header: ({ column }) => {
          if (!keyIsAcciones) {
            return (
              <DataTableColumnHeader
                key={uuid()}
                column={column}
                title={title}
              />
            );
          }
        },
        cell: ({ row }) => {
          if (keyIsAcciones && row.original.url && row.original.id) {
            console.debug("generando acciones...");
            return (
              <RowActionsLiveEdit
                url={row.original.url}
                id={row.original.id}
                info={{ nombre: row.original.nombre ?? "" }}
              />
            );
          }
          return row.original[key];
        },
        size: keyIsAcciones ? 5 : undefined,
        meta: {
          header: title,
          key: key,
        },
      });
    }
  }

  return column;
}
