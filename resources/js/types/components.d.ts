import { PropsWithChildren, ReactElement } from "react";
import { UUID } from "./modelos";
import { ColumnDef } from "@tanstack/react-table";

interface IconProps {
  className?: string;
}

type Breadcrumbs = {
  icon?: ReactElement;
  text: string;
  url: string;
};

type Actions =
  | "index"
  | "create"
  | "store"
  | "show"
  | "edit"
  | "update"
  | "destroy";

interface NavbarProps extends PropsWithChildren {
  username: string;
  email: string;
}

interface MainLayoutProps extends PropsWithChildren {
  className?: string;
}

interface TableProps<TData, TValue> {
  title: string;
  data: any;
  columns: ColumnDef<Record<string, unknown>, any>[] | ColumnDef<any, any>[];
  url: string;
  initialVisibility?: Record<string, boolean>;
  withPrompt?: boolean;
}

export interface LayoutProps extends PropsWithChildren {
  id?: UUID;
  pageTitle: string;
  mainTitle: string;
  created_at?: Date | string;
  updated_at?: Date | string;
  url: string;
}
