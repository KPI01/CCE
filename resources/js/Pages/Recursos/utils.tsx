import {
  AtSign,
  Box,
  Building,
  CircleArrowOutUpRight,
  FilePen,
  FilePlus,
  Home,
  Send,
  Sheet,
  Table,
  Tractor,
  Trash,
  UserRound,
} from "lucide-react";

export const CONTAINER_CLASS = "container grid grid-cols-2 gap-x-12 gap-y-4";
const ICON_CLASS = "size-4 mr-2";

export const REQUIRED_MSG = (start: string) => `${start} es requerido.`;
export const MIN_MESSAGE = (size: number) =>
  `Este campo debe tener al menos ${size} caracteres.`;
export const MAX_MESSAGE = (size: number) =>
  `Este campo debe tener como máximo ${size} caracteres`;
export const BE_VALID_MSG = (start: string) => `${start} debe ser válido.`;

export const HomeIcon = <Home className={ICON_CLASS} />;
export const RecursosIcon = <Box className={ICON_CLASS} />;
export const PersonaIcon = <UserRound className={ICON_CLASS} />;
export const EmailIcon = <AtSign className={ICON_CLASS} />;
export const TablasAuxiliaresIcon = <Table className={ICON_CLASS} />;
export const EmpresaIcon = <Building className={ICON_CLASS} />;
export const MaquinaIcon = <Tractor className={ICON_CLASS} />;

export const TablaIcon = <Sheet className={ICON_CLASS} />;
export const EditIcon = <FilePen className={ICON_CLASS} />;
export const SaveUpdateIcon = <CircleArrowOutUpRight className={ICON_CLASS} />;
export const DeleteIcon = <Trash className={ICON_CLASS} />;
export const SendIcon = <Send className={ICON_CLASS} />;
export const CreateIcon = <FilePlus className={ICON_CLASS} />;

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
