export default function FormTitle({ title, id }: { title: string, id: string }) {
  return <h3 id={id} className="font-bold text-xl mb-4 col-span-2">{title}</h3>;
}
