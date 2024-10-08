import { PropsWithChildren, ReactElement } from "react";
import { UUID } from "./modelos";

interface IconProps {
  className?: string;
  strokeWidth?: number;
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

export interface LayoutProps extends PropsWithChildren {
  id?: UUID;
  pageTitle: string;
  mainTitle: string;
  created_at?: Date | string;
  updated_at?: Date | string;
  url: string;
}
