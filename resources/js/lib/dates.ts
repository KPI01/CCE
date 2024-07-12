export const formatDate = (date: Date) => {
  return date.toLocaleString(import.meta.env.VITE_LOCALE, {
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit",
    second: "2-digit",
  });
};
