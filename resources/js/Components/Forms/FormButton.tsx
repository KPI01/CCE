import { PropsWithChildren } from "react";
import { Button, ButtonProps } from "../ui/button";
import { cn } from "@/lib/utils";

interface BaseProps extends PropsWithChildren {
  className?: string;
  id?: string;
  onClick?: () => void;
  type?: 'submit' | 'reset' | 'button'
  variant?: ButtonProps['variant'];
}

interface FormButtonPropsWithText extends BaseProps {
  text?: string;
}

export default function FormButton({
  children,
  className,
  id,
  onClick = undefined,
  text,
  type = 'button',
  variant = 'default',
}: BaseProps & FormButtonPropsWithText) {
  const content = children ? children : text
  const buttonClass = cn('w-fit', className)
  
  return (
    <Button 
    variant={variant}
    type={type}
    id={id} 
    onClick={onClick} 
    className={buttonClass}>
      {content}
    </Button>
  )
}