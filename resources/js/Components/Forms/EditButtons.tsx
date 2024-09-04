import { DeleteIcon, SaveUpdateIcon } from "@/Pages/Recursos/utils";
import FormButton from "./FormButton";

type FnVoid<> = () => void;

export default function EditButtons({
  destroyCallback,
}: {
  destroyCallback: FnVoid;
}) {
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
