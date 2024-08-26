import { cn } from "@/lib/utils";
import { IconProps } from "@/types";
import {
  Box,
  Building,
  CircleArrowOutUpRight,
  FilePen,
  FilePlus,
  Send,
  Sheet,
  Tractor,
  Trash,
  UserRound,
} from "lucide-react";

export const CONTAINER_CLASS = "container grid grid-cols-2 gap-x-12 gap-y-4";
const ICON_CLASS = "size-4 mr-2";

export const REQUIRED_MSG = (start: string, end: "a" | "o" = "o") =>
  `${start} es requerid${end}.`;
export const MIN_MESSAGE = (size: number) =>
  `Este campo debe tener al menos ${size} caracteres.`;
export const MAX_MESSAGE = (size: number) =>
  `Este campo debe tener como máximo ${size} caracteres`;
export const BE_VALID_MSG = (start: string) => `${start} debe ser válido.`;

export const RecursosIcon = ({ className }: IconProps) => (
  <Box className={cn(ICON_CLASS, className)} />
);
export const PersonaIcon = ({ className }: IconProps) => (
  <UserRound className={cn(ICON_CLASS, className)} />
);
export const EmpresaIcon = ({ className }: IconProps) => (
  <Building className={cn(ICON_CLASS, className)} />
);
export const MaquinaIcon = ({ className }: IconProps) => (
  <Tractor className={cn(ICON_CLASS, className)} />
);

export const TablaIcon = ({ className }: IconProps) => (
  <Sheet className={cn(ICON_CLASS, className)} />
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

export function urlWithoutId(url: string) {
  if (!url.lastIndexOf("/")) {
    console.error("La url debe tener /");
    return url;
  }
  return url.slice(0, url.lastIndexOf("/"));
}

export function toSend(
  dirty: typeof Object | any,
  data: any,
): {
  [key: string]: any;
} {
  return Object.keys(dirty).reduce(
    (acc, key) => {
      const aux: { [key: string]: any } = data;
      if (key in aux) {
        acc[key] = aux[key];
      }
      return acc;
    },
    {} as { [key: string]: any },
  );
}

export function nullToUndefined<T>(obj: T): T {
  let copy = { ...obj };

  for (const key in obj) {
    if (obj[key] === null) {
      copy = { ...copy, [key]: undefined };
    } else if (typeof obj[key] === "object") {
      copy = { ...copy, [key]: nullToUndefined(obj[key]) };
    }
  }

  return copy;
}
