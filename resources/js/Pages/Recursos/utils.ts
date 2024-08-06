export const CONTAINER_CLASS = "container grid grid-cols-2 gap-x-12 gap-y-4";
export const ICON_CLASS = "size-4 mr-2";

export const REQUIRED_MSG = (start: string) => `${start} es requerido.`;
export const MIN_MESSAGE = (size: number) =>
  `Este campo debe tener al menos ${size} caracteres.`;
export const MAX_MESSAGE = (size: number) =>
  `Este campo debe tener como máximo ${size} caracteres`;
export const BE_VALID_MSG = (start: string) => `${start} debe ser válido.`;
