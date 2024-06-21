import { FormControl, FormItem, FormLabel, FormMessage } from "../ui/form"
import { Input } from "../ui/input"
import { Textarea } from "../ui/textarea"

interface Props extends ConstructorProps {
    textarea?: boolean
}

export default function FormItemConstructor({
    id,
    label,
    name,
    value,
    onChange,
    disabled = false,
    placeholder,
    textarea = false
}: Props) {

    if (textarea) {
        return (
            <FormItem className="grid grid-cols-1 col-span-2 items-center">
                <FormLabel htmlFor={id}>{label}</FormLabel>
                <FormControl>
                    <Textarea
                        id={id}
                        name={name}
                        value={value}
                        onChange={onChange}
                        disabled={disabled}
                        placeholder={placeholder}
                    />
                </FormControl>
                <FormMessage id={`${name}-message`} />
            </FormItem>
        )
    }

    return (
        <FormItem className="grid grid-cols-[15ch_1fr] items-center">
            <FormLabel htmlFor={id}>{label}</FormLabel>
            <FormControl>
                <Input
                    id={id}
                    name={name}
                    value={value}
                    onChange={onChange}
                    disabled={disabled}
                    placeholder={placeholder}
                />
            </FormControl>
            <FormMessage id={`${name}-message`} />
        </FormItem>
    )
}
