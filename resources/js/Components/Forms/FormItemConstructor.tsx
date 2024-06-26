import { cn } from "@/lib/utils";
import { FormControl, FormItem, FormLabel, FormMessage } from "../ui/form";
import { Input } from "../ui/input";
import { Textarea } from "../ui/textarea";

interface Props extends ConstructorProps {
  textarea?: boolean;
  inputStyle?: React.CSSProperties;
  itemStyle?: React.CSSProperties;
  itemClass?: string;
  inputClass?: string;
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
}: Props) {
  const InputField = textarea ? Textarea : Input;
  // console.debug({name, withLabel})

  const Label = (
    <FormLabel htmlFor={id} className="leading-0">
      {label}
    </FormLabel>
  );

  const formItemClass = cn("grid gap-x-2 items-center", itemClass);
  const formItemStyle = { gridTemplateColumns: "15ch 1fr", ...itemStyle };
  const controlInputStyle = {
    gridTemplateColumns: "15ch 1fr",
    marginTop: 0,
    ...inputStyle,
  };
  const controlInputClass = cn("grid items-center", inputClass);

  return (
    <FormItem className={formItemClass} style={formItemStyle}>
      {withLabel && Label}
      <FormControl>
        <InputField
          id={id}
          name={name}
          value={value || ""}
          onChange={onChange}
          disabled={disabled}
          placeholder={placeholder}
          className={controlInputClass}
          style={controlInputStyle}
        />
      </FormControl>
      <FormMessage id={`${id}-message`} />
    </FormItem>
  );
}
