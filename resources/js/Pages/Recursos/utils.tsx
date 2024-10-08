import { cn } from "@/lib/utils";
import { IconProps } from "@/types";
import {
  Building,
  CalendarRange,
  CircleArrowOutUpRight,
  FilePen,
  FilePlus,
  Send,
  Sheet,
  Sprout,
  Tractor,
  Trash,
} from "lucide-react";

export const CONTAINER_CLASS = "container grid grid-cols-2 gap-x-12 gap-y-4";
const ICON_CLASS = "size-4 mr-2";

export const REQUIRED_MSG = (start: string, end: "a" | "o" = "o") =>
  `${start} es requerid${end}.`;
export const MIN_MESSAGE = (size: number) =>
  `Este campo debe tener al menos ${size} caracteres.`;
export const MAX_MESSAGE = (size: number) =>
  `Este campo debe tener como máximo ${size} caracteres.`;
export const TYPE_MESSAGE = (field: string, type: string) => {
  return `${field} debe ser: ${type}.`;
};
export const BE_VALID_MSG = (start: string, end: "a" | "o" = "o") =>
  `${start} debe ser válid${end}.`;
export const NOT_CONTAIN_MSG = (start: string, prohibited: string[]) =>
  `${start} no debe contener: ${prohibited.join(", ")}.`;
export const ONLY_CONTAIN_MSG = (start: string, allowed: string[]) =>
  `${start} sólo debe contener: ${allowed.join(", ")}.`;

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

export function convertToType<T>({
  val,
  type,
}: {
  val: any;
  type: "string" | "number" | "boolean" | "date";
}): T {
  console.debug(val, typeof val);
  if (type === "string") {
    try {
      return String(val) as T;
    } catch (e) {
      console.error("Error al convertir a string");
      throw e;
    }
  } else if (type === "number") {
    try {
      return Number(val) as T;
    } catch (e) {
      console.error("Error al convertir a número");
      throw e;
    }
  } else if (type === "boolean") {
    try {
      return Boolean(val) as T;
    } catch (e) {
      console.error("Error al convertir a booleano");
      throw e;
    }
  } else if (type === "date") {
    try {
      return new Date(val) as T;
    } catch (e) {
      console.error("Error al convertir a fecha");
      throw e;
    }
  }
  return val;
}
