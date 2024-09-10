import { DeleteIcon, SaveUpdateIcon, SendIcon } from "@/Pages/Recursos/utils";
import FormButton from "./FormButton";

type FnVoid = () => void;

export function CreateFormFooter() {
  return (
    <div className="col-span-full w-full">
      <p className="mb-3 ml-auto w-fit text-sm">
        Los campos marcados con (*) son obligatorios
      </p>
      <FormButton type="submit" className="ms-auto flex">
        <SendIcon />
        Enviar
      </FormButton>
    </div>
  );
}

export function EditButtons({ destroyCallback }: { destroyCallback: FnVoid }) {
  return (
    <div className="col-span-full flex items-center gap-16">
      <FormButton
        id="destroy"
        variant={"destructive"}
        className="ms-auto"
        onClick={destroyCallback}
      >
        <DeleteIcon />
        Eliminar
      </FormButton>
      <FormButton type="submit">
        <SaveUpdateIcon />
        Actualizar
      </FormButton>
    </div>
  );
}
