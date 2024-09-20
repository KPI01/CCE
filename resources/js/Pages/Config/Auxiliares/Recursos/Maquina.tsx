import DataLayout from "@/Layouts/DataLayout";
import { createColumn } from "../utils";

type Row = Record<string, unknown>;

interface Props {
  title: string;
  rows: Row[];
  url: string;
}

export default function Maquina({ title, rows, url }: Props) {
  console.debug("title:", title, "rows:", rows);
  const columns = createColumn(rows[0]) ?? [];
  console.debug("columns:", columns);
  return (
    <DataLayout
      title={title}
      url={url}
      columns={columns}
      data={rows}
      withPrompt
    />
  );
}
