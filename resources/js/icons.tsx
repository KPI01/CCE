import { AtSign, Box, Home, Table, UserRound } from "lucide-react";
import { IconProps } from "./types";
import { cn } from "./lib/utils";

const ICON_CLASS = "size-4 mr-2";

export const HomeIcon = ({ className }: IconProps) => (
  <Home className={cn(ICON_CLASS, className)} />
);
export const EmailIcon = ({ className }: IconProps) => (
  <AtSign className={cn(ICON_CLASS, className)} />
);
export const TablasAuxiliaresIcon = ({ className }: IconProps) => (
  <Table className={cn(ICON_CLASS, className)} />
);

export const RecursosIcon = ({ className }: IconProps) => (
  <Box className={cn(ICON_CLASS, className)} />
);

export const PersonaIcon = ({ className = "" }: IconProps) => (
  <UserRound className={cn(ICON_CLASS, className)} />
);
