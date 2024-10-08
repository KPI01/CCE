import {
  ColumnDef,
  SortingState,
  VisibilityState,
} from "@tanstack/react-table";

type TableState = {
  visibility: VisibilityState;
  sorting: SortingState;
};

export interface DataTableProps<TData, TValue> {
  config: {
    columns: ColumnDef<TData, TValue>[];
    data: TData[];
  };
  state?: Partial<TableState>;
}
