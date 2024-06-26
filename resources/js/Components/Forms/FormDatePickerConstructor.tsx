import { cn } from "@/lib/utils";
import { Button } from "../ui/button";
import {
  FormControl,
  FormDescription,
  FormItem,
  FormLabel,
  FormMessage,
} from "../ui/form";
import { Popover, PopoverContent, PopoverTrigger } from "../ui/popover";
import { format } from "date-fns";
import { Input } from "../ui/input";
import { CalendarDays } from "lucide-react";
import { Calendar } from "../ui/calendar";
import { es } from "date-fns/locale";

interface Props {
  id: string;
  name: string;
  value: Date | undefined;
  onChange: (...events: any[]) => void;
  description?: string;
  label: string;
  withLabel?: boolean;
  itemClass?: string;
  itemStyle?: React.CSSProperties;
  triggerClass?: string;
  triggerStyle?: React.CSSProperties;
}

export default function FormDatePickerConstructor({
  id,
  name,
  value,
  onChange,
  description,
  label,
  itemClass,
  itemStyle,
  withLabel = true,
  triggerClass,
  triggerStyle,
}: Props) {
  const Label = (
    <FormLabel htmlFor={`${id}-btn`} className="leading-4">
      {label}
    </FormLabel>
  );

  const customItemClass = cn("grid gap-x-2 items-center", itemClass);
  const customStyle = { gridTemplateColumns: "15ch 1fr", ...itemStyle };
  const customTriggerClass = cn("grid items-center", triggerClass);
  const customTriggerStyle = {
    gridTemplateColumns: "15ch 1fr",
    marginTop: 0,
    ...triggerStyle,
  };

  return (
    <FormItem className={customItemClass} style={customStyle}>
      {withLabel && Label}
      <Popover>
        <PopoverTrigger
          id={`${id}-trigger`}
          className={customTriggerClass}
          style={customTriggerStyle}
          asChild
        >
          <FormControl>
            <Button
              id={`${id}-btn`}
              variant={"outline"}
              className={cn(
                "pl-3 text-left font-normal mt-0",
                !value && "text-muted-foreground",
              )}
              value={value ? format(value, "dd/MM/yyyy") : "dd/mm/aaaa"}
            >
              <span id={`${id}-value`}>
                {value ? format(value, "dd/MM/yyyy") : "dd/mm/aaaa"}
              </span>
              <Input
                id={`${id}-input`}
                type="hidden"
                name={name}
                value={value ? format(value, "yyyy-MM-dd") : ""}
                onChange={onChange}
              />
              <CalendarDays className="ml-auto h-4 w-4 opacity-50" />
            </Button>
          </FormControl>
        </PopoverTrigger>
        <PopoverContent className="w-auto p-0" align="start">
          <Calendar
            id={`${id}-calendar`}
            mode="single"
            locale={es}
            selected={value}
            onSelect={onChange}
            disabled={(date) => date < new Date()}
          />
        </PopoverContent>
      </Popover>
      {description && <FormDescription>{description}</FormDescription>}
      <FormMessage id={`${id}-message`} />
    </FormItem>
  );
}
