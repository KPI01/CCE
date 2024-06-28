import { cn } from "@/lib/utils";
import { FormControl, FormDescription, FormItem, FormLabel, FormMessage } from "../ui/form";
import { Input } from "../ui/input";
import { Textarea } from "../ui/textarea";

interface Props extends ConstructorProps {
  textarea?: boolean;
  inputStyle?: React.CSSProperties;
  itemStyle?: React.CSSProperties;
  itemClass?: string;
  inputClass?: string;
  autoComplete?: 'name' | 'given-name' | 'family-name' | 'email' | 'tel' | 'off' | 'on';
}

export default function FormItemConstructor({
  id,
  label,
  name,
  value,
  onChange,
  disabled = false,
  placeholder = "...",
  textarea = false,
  withLabel = true,
  itemStyle,
  inputStyle = { columnSpan: "none" },
  inputClass,
  itemClass,
  autoComplete = "off",
  descrip = undefined,
}: Props) {
  const toId = id.includes(".") ? id.replace(".", "_") : id;
  const inputId = `input-${toId}`;
  const labelId = `label-${toId}`;

  const InputField = textarea ? Textarea : Input;
  // console.debug({name, withLabel})

  const Label = (
    <FormLabel id={labelId} htmlFor={inputId} className="leading-0">
      {label}
    </FormLabel>
  );

  const Descrip = <FormDescription className="select-none text-xs col-start-2">{descrip}</FormDescription>;

  const formItemClass = cn("grid gap-x-2 items-center", itemClass);
  const formItemStyle = { gridTemplateColumns: "15ch 1fr", ...itemStyle };
  const controlInputStyle = {
    gridTemplateColumns: "15ch 1fr",
    marginTop: 0,
    ...inputStyle,
  };
  const controlInputClass = cn("grid items-center max-h-48", inputClass);

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
      {descrip && Descrip}
      <FormMessage id={`${id}-message`} className="col-start-1 row-start-2" />
    </FormItem>
  );
}
