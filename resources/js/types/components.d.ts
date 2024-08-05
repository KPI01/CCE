import { PropsWithChildren } from "react";
import { UUID } from "./modelos";
import { Urls } from ".";

type Breadcrumbs = {
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
  id?: UUID;
}

interface MainLayoutProps extends PropsWithChildren {
  className?: string;
  id?: UUID;
}

interface TableProps {
  title: string;
  data: any;
  columns: any;
  recurso: string;
  initialVisibility: any;
}

export interface LayoutProps extends PropsWithChildren {
  id?: UUID;
  pageTitle: string;
  mainTitle: string;
  created_at?: Date | string;
  updated_at?: Date | string;
  urls: Urls | Partial<Urls>;
}

export type ActionUrls = Required<Pick<Urls, "show" | "edit" | "destroy">>;
