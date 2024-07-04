export default function FormTitle({
  title,
  id,
}: {
  title: string;
  id: string;
}) {
  return (
    <h3 id={id} className="col-span-2 mb-4 text-xl font-bold">
      {title}
    </h3>
  );
}
