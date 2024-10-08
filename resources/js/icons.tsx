import {
  AtSign,
  Box,
  Building,
  CalendarRange,
  CircleArrowOutUpRight,
  FilePen,
  FilePlus,
  FileQuestion,
  FolderOpen,
  Home,
  Send,
  Sprout,
  Table,
  Table2,
  Tractor,
  Trash,
  UserRound,
} from "lucide-react";
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

export const EmpresaIcon = ({ className }: IconProps) => (
  <Building className={cn(ICON_CLASS, className)} />
);
export const MaquinaIcon = ({ className }: IconProps) => (
  <Tractor className={cn(ICON_CLASS, className)} />
);
export const CampanaIcon = ({ className }: IconProps) => (
  <CalendarRange className={cn(ICON_CLASS, className)} />
);
export const CultivoIcon = ({ className }: IconProps) => (
  <Sprout className={cn(ICON_CLASS, className)} />
);

export const TablaIcon = ({ className }: IconProps) => (
  <Table2 className={cn(ICON_CLASS, className)} />
);
export const EditIcon = ({ className }: IconProps) => (
  <FilePen className={cn(ICON_CLASS, className)} />
);
export const SaveUpdateIcon = ({ className }: IconProps) => (
  <CircleArrowOutUpRight className={cn(ICON_CLASS, className)} />
);
export const DeleteIcon = ({ className }: IconProps) => (
  <Trash className={cn(ICON_CLASS, className)} />
);
export const SendIcon = ({ className }: IconProps) => (
  <Send className={cn(ICON_CLASS, className)} />
);
export const CreateIcon = ({ className }: IconProps) => (
  <FilePlus className={cn(ICON_CLASS, className)} />
);

export const EmptyIcon = ({ className, strokeWidth = 1 }: IconProps) => (
  <FolderOpen className={cn(ICON_CLASS, className)} strokeWidth={strokeWidth} />
);
