import { PropsWithChildren } from "react";
import { UUID } from "./modelos";

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
  isAdmin: boolean;
}

interface MainLayoutProps extends PropsWithChildren {
  className?: string;
}

interface TableProps {
  title: string;
  data: any;
  columns: any;
  recurso: string;
  initialVisibility: any;
}

type Urls = {
  show?: string;
  index?: string;
  store?: string;
  update?: string;
  edit?: string;
  destroy?: string;
};

export interface LayoutProps extends PropsWithChildren {
  id?: UUID;
  pageTitle: string;
  mainTitle: string;
  created_at?: string;
  updated_at?: string;
  urls?: Urls;
}

export type ActionUrls = Required<Pick<Urls, "show" | "edit" | "destroy">>;
