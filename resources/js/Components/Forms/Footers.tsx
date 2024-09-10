import { SendIcon } from "@/Pages/Recursos/utils";
import FormButton from "./FormButton";

export default function CreateFormFooter() {
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
