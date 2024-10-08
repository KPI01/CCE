import { DataTableProps } from "@/Components/DataTable";
import { ColumnDef } from "@tanstack/react-table";

interface TableProps<TData, TValue> {
  title: string;
  data: any;
  columns: ColumnDef<Record<string, unknown>, any>[] | ColumnDef<any, any>[];
  url: string;
  state?: DataTableProps<TData, TValue>["state"];
}
