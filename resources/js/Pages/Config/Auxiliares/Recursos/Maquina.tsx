import DataLayout from "@/Layouts/DataLayout";
import { createColumn } from "../utils";

type Row = Record<string, unknown>;

interface Props {
  title: string;
  cols: string[];
  rows: Row[];
  url: string;
}

export default function Maquina({ title, cols, rows, url }: Props) {
  console.log("title:", title, "cols:", cols, "rows:", rows);
  const columns = createColumn(rows[0]);
  console.log("columns:", columns);
  let initialVisibility: Record<keyof (typeof rows)[0], boolean> = {};
  for (const key in rows[0]) {
    initialVisibility[key] = true;
  }
  return (
    <DataLayout
      title={title}
      url={url}
      columns={columns}
      data={rows}
      initialVisibility={initialVisibility}
    />
  );
}
