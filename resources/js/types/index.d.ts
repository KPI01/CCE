import { User } from "./modelos";

export interface Message {
  content?: string;
  toast?: {
    variant: "default" | "destructive";
    title: string;
    description: string;
  };
}

export interface Flash {
  from: string;
  message: Message;
}

export interface Auth {
  user: User;
}

export type PageProps<
  T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
  appName: string;
  flash?: Flash;
  _previous: {
    url: string;
  };
  auth: {
    user: {
      id: number;
      name: string;
      email: string;
      email_verified_at: string;
      role: {
        id: number;
        name: string;
      };
    };
  };
};

export * from "./modelos";
export * from "./components";
export * from "./data-table";
export * from "./auxiliares";
