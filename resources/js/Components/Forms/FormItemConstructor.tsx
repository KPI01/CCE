import { cn } from "@/lib/utils";
import {
  FormControl,
  FormDescription,
  FormItem,
  FormLabel,
  FormMessage,
} from "../ui/form";
import { Input } from "../ui/input";
import { Textarea } from "../ui/textarea";

interface Props extends ConstructorProps {
  textarea?: boolean;
  inputStyle?: React.CSSProperties;
  itemStyle?: React.CSSProperties;
  itemClass?: string;
  inputClass?: string;
  msgClass?: string;
  autoComplete?:
    | "name"
    | "given-name"
    | "family-name"
    | "email"
    | "tel"
    | "off"
    | "on"
    | "organization"
    | "street-address";
}

export default function FormItemConstructor({
  id,
  label,
  name,
  value,
  onChange,
  disabled = false,
  placeholder = "(Vacío)",
  textarea = false,
  withLabel = true,
  itemStyle,
  inputStyle = { columnSpan: "none" },
  inputClass,
  itemClass,
  autoComplete = "off",
  msgClass,
  descripcion = undefined,
}: Props) {
  const toId = id.includes(".") ? id.replace(".", "_") : id;
  const inputId = `input-${toId}`;
  const labelId = `label-${toId}`;
  const descripId = `descrip-${toId}`;

  const InputField = textarea ? Textarea : Input;

  const Label = (
    <FormLabel id={labelId} htmlFor={inputId} className="leading-0">
      {label}
    </FormLabel>
  );

  const Descripcion = (
    <FormDescription id={descripId} className="col-start-2 select-none text-xs">
      {descripcion}
    </FormDescription>
  );

  const formItemClass = cn("grid gap-x-2 items-center", itemClass);
  const formItemStyle = { gridTemplateColumns: "15ch 1fr", ...itemStyle };
  const controlInputStyle = {
    gridTemplateColumns: "15ch 1fr",
    marginTop: 0,
    ...inputStyle,
  };
  const controlInputClass = cn("grid items-center max-h-48", inputClass);
  const formMsgClass = cn("col-span-full row-start-2", msgClass);

  return (
    <FormItem className={formItemClass} style={formItemStyle}>
      {withLabel && Label}
      <FormControl>
        <InputField
          id={inputId}
          name={name}
          value={value || ""}
          onChange={onChange}
          disabled={disabled}
          placeholder={placeholder}
          className={controlInputClass}
          style={controlInputStyle}
          autoComplete={autoComplete}
        />
      </FormControl>
      {descripcion && Descripcion}
      <FormMessage id={`msg-${toId}`} className={formMsgClass} />
    </FormItem>
  );
}
