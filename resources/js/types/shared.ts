type Flash = {
    success?: string;
    error?: string;
    info?: string;
};

type PHPEnums = {
    visibility: {
        PUBLIC: string,
        PRIVATE: string,
        PROTECTED: string,
    };
};

export type AppServiceShared = {
    appName: string;
    enums: PHPEnums;
    flash: Flash;
};