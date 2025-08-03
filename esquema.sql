--
-- PostgreSQL database dump
--

-- Dumped from database version 16.9 (Ubuntu 16.9-0ubuntu0.24.04.1)
-- Dumped by pg_dump version 16.9 (Ubuntu 16.9-0ubuntu0.24.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: dictamen; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.dictamen (
    id bigint NOT NULL,
    solicitud_id bigint NOT NULL,
    guia character varying(255) NOT NULL,
    numero_carpeta integer NOT NULL,
    observaciones character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.dictamen OWNER TO postgres;

--
-- Name: dictamen_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.dictamen_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.dictamen_id_seq OWNER TO postgres;

--
-- Name: dictamen_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.dictamen_id_seq OWNED BY public.dictamen.id;


--
-- Name: direccion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.direccion (
    id bigint NOT NULL,
    estado character varying(255) NOT NULL,
    municipio character varying(255) NOT NULL,
    parroquia character varying(255) NOT NULL,
    calle character varying(255) NOT NULL,
    "casa-edificio" character varying(255) NOT NULL,
    piso character varying(255) NOT NULL,
    apartamento character varying(255) NOT NULL,
    updated_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.direccion OWNER TO postgres;

--
-- Name: direccion_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.direccion_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.direccion_id_seq OWNER TO postgres;

--
-- Name: direccion_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.direccion_id_seq OWNED BY public.direccion.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: funcionario; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.funcionario (
    id bigint NOT NULL,
    persona_id bigint NOT NULL,
    unidad_administrativa_id bigint,
    credencial character varying(255),
    rango character varying(255),
    cargo character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.funcionario OWNER TO postgres;

--
-- Name: funcionario_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.funcionario_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.funcionario_id_seq OWNER TO postgres;

--
-- Name: funcionario_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.funcionario_id_seq OWNED BY public.funcionario.id;


--
-- Name: guide_sequences; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.guide_sequences (
    id bigint NOT NULL,
    type character varying(255) NOT NULL,
    year integer NOT NULL,
    last_number integer DEFAULT 0 NOT NULL,
    preview character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.guide_sequences OWNER TO postgres;

--
-- Name: COLUMN guide_sequences.type; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.guide_sequences.type IS 'Tipo de guía';


--
-- Name: COLUMN guide_sequences.preview; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.guide_sequences.preview IS 'Número de guía generado previamente';


--
-- Name: guide_sequences_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.guide_sequences_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.guide_sequences_id_seq OWNER TO postgres;

--
-- Name: guide_sequences_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.guide_sequences_id_seq OWNED BY public.guide_sequences.id;


--
-- Name: imagen; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.imagen (
    id bigint NOT NULL,
    fecha_registro date NOT NULL,
    tipo character varying(255) NOT NULL,
    url character varying(255) NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL,
    created_at timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.imagen OWNER TO postgres;

--
-- Name: imagen_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.imagen_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.imagen_id_seq OWNER TO postgres;

--
-- Name: imagen_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.imagen_id_seq OWNED BY public.imagen.id;


--
-- Name: imagen_solicitud; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.imagen_solicitud (
    id bigint NOT NULL,
    imagen_id bigint NOT NULL,
    solicitud_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.imagen_solicitud OWNER TO postgres;

--
-- Name: imagen_solicitud_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.imagen_solicitud_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.imagen_solicitud_id_seq OWNER TO postgres;

--
-- Name: imagen_solicitud_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.imagen_solicitud_id_seq OWNED BY public.imagen_solicitud.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: model_has_permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.model_has_permissions (
    permission_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);


ALTER TABLE public.model_has_permissions OWNER TO postgres;

--
-- Name: model_has_roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.model_has_roles (
    role_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);


ALTER TABLE public.model_has_roles OWNER TO postgres;

--
-- Name: nomenclador_geografico; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.nomenclador_geografico (
    id bigint NOT NULL,
    nombre character varying(255),
    tipo integer,
    padre integer,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.nomenclador_geografico OWNER TO postgres;

--
-- Name: nomenclador_geografico_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.nomenclador_geografico_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.nomenclador_geografico_id_seq OWNER TO postgres;

--
-- Name: nomenclador_geografico_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.nomenclador_geografico_id_seq OWNED BY public.nomenclador_geografico.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- Name: permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.permissions (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.permissions OWNER TO postgres;

--
-- Name: permissions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.permissions_id_seq OWNER TO postgres;

--
-- Name: permissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.permissions_id_seq OWNED BY public.permissions.id;


--
-- Name: persona; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.persona (
    id bigint NOT NULL,
    primer_nombre character varying(255) NOT NULL,
    segundo_nombre character varying(255),
    primer_apellido character varying(255) NOT NULL,
    segundo_apellido character varying(255),
    nacionalidad character varying(255) NOT NULL,
    cedula character varying(255) NOT NULL,
    sexo character varying(255) NOT NULL,
    correo character varying(255) NOT NULL,
    imagen_id bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.persona OWNER TO postgres;

--
-- Name: persona_direccion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.persona_direccion (
    id bigint NOT NULL,
    persona_id bigint NOT NULL,
    direccion_id bigint NOT NULL
);


ALTER TABLE public.persona_direccion OWNER TO postgres;

--
-- Name: persona_direccion_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.persona_direccion_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.persona_direccion_id_seq OWNER TO postgres;

--
-- Name: persona_direccion_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.persona_direccion_id_seq OWNED BY public.persona_direccion.id;


--
-- Name: persona_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.persona_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.persona_id_seq OWNER TO postgres;

--
-- Name: persona_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.persona_id_seq OWNED BY public.persona.id;


--
-- Name: persona_telefono; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.persona_telefono (
    id bigint NOT NULL,
    persona_id bigint NOT NULL,
    telefono_id bigint NOT NULL
);


ALTER TABLE public.persona_telefono OWNER TO postgres;

--
-- Name: persona_telefono_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.persona_telefono_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.persona_telefono_id_seq OWNER TO postgres;

--
-- Name: persona_telefono_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.persona_telefono_id_seq OWNED BY public.persona_telefono.id;


--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.personal_access_tokens_id_seq OWNER TO postgres;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: registro_policial; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.registro_policial (
    id bigint NOT NULL,
    solicitud_id bigint,
    guia character varying(255) NOT NULL,
    numero_oficio integer NOT NULL,
    fecha_oficio date NOT NULL,
    nombre_tribunal character varying(255) NOT NULL,
    numero_expediente_tribunal character varying(255) NOT NULL,
    motivo character varying(255) NOT NULL,
    verificado boolean DEFAULT false NOT NULL,
    verificadopor_persona_id bigint,
    fecha_verificacion date,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.registro_policial OWNER TO postgres;

--
-- Name: registro_policial_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.registro_policial_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.registro_policial_id_seq OWNER TO postgres;

--
-- Name: registro_policial_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.registro_policial_id_seq OWNED BY public.registro_policial.id;


--
-- Name: registro_solicitud; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.registro_solicitud (
    id bigint NOT NULL,
    solicitud_id bigint NOT NULL,
    delito character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.registro_solicitud OWNER TO postgres;

--
-- Name: registro_solicitud_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.registro_solicitud_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.registro_solicitud_id_seq OWNER TO postgres;

--
-- Name: registro_solicitud_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.registro_solicitud_id_seq OWNED BY public.registro_solicitud.id;


--
-- Name: registro_unico; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.registro_unico (
    id bigint NOT NULL,
    solicitud_id bigint NOT NULL,
    guia character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.registro_unico OWNER TO postgres;

--
-- Name: registro_unico_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.registro_unico_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.registro_unico_id_seq OWNER TO postgres;

--
-- Name: registro_unico_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.registro_unico_id_seq OWNED BY public.registro_unico.id;


--
-- Name: role_has_permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.role_has_permissions (
    permission_id bigint NOT NULL,
    role_id bigint NOT NULL
);


ALTER TABLE public.role_has_permissions OWNER TO postgres;

--
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.roles (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.roles OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.roles_id_seq OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- Name: solicitud; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.solicitud (
    id bigint NOT NULL,
    tipo_solicitud character varying(255) NOT NULL,
    fecha_registro date NOT NULL,
    registrador_funcionario_id bigint NOT NULL,
    solicitante_persona_id bigint NOT NULL,
    fecha_solicitud date NOT NULL,
    hora_solicitud time(0) without time zone NOT NULL,
    estado_solicitud character varying(255) NOT NULL,
    apoderado_persona_id bigint,
    abogado_funcionario_id bigint NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    updated_at timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.solicitud OWNER TO postgres;

--
-- Name: solicitud_administrativa; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.solicitud_administrativa (
    id bigint NOT NULL,
    solicitud_id bigint NOT NULL,
    guia character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.solicitud_administrativa OWNER TO postgres;

--
-- Name: solicitud_administrativa_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.solicitud_administrativa_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.solicitud_administrativa_id_seq OWNER TO postgres;

--
-- Name: solicitud_administrativa_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.solicitud_administrativa_id_seq OWNED BY public.solicitud_administrativa.id;


--
-- Name: solicitud_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.solicitud_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.solicitud_id_seq OWNER TO postgres;

--
-- Name: solicitud_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.solicitud_id_seq OWNED BY public.solicitud.id;


--
-- Name: telefono; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.telefono (
    id bigint NOT NULL,
    numero character varying(255) NOT NULL,
    tipo character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.telefono OWNER TO postgres;

--
-- Name: telefono_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.telefono_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.telefono_id_seq OWNER TO postgres;

--
-- Name: telefono_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.telefono_id_seq OWNED BY public.telefono.id;


--
-- Name: traza_acceso; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.traza_acceso (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    ip character varying(255) NOT NULL,
    login timestamp(0) without time zone NOT NULL,
    logout timestamp(0) without time zone,
    fallido character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.traza_acceso OWNER TO postgres;

--
-- Name: traza_acceso_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.traza_acceso_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.traza_acceso_id_seq OWNER TO postgres;

--
-- Name: traza_acceso_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.traza_acceso_id_seq OWNED BY public.traza_acceso.id;


--
-- Name: unidad_administrativa; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.unidad_administrativa (
    id bigint NOT NULL,
    nombre character varying(255),
    codigo character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.unidad_administrativa OWNER TO postgres;

--
-- Name: unidad_administrativa_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.unidad_administrativa_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.unidad_administrativa_id_seq OWNER TO postgres;

--
-- Name: unidad_administrativa_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.unidad_administrativa_id_seq OWNED BY public.unidad_administrativa.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    funcionario_id bigint NOT NULL,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    intentos_fallidos integer DEFAULT 0 NOT NULL,
    habilitado boolean DEFAULT false NOT NULL,
    eliminado boolean DEFAULT false NOT NULL,
    bloqueado boolean DEFAULT false NOT NULL,
    fecha_ultimo_cambio_contrasena timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    observaciones character varying(255),
    pregunta_1 character varying(255),
    respuesta_1 character varying(255),
    pregunta_2 character varying(255),
    respuesta_2 character varying(255),
    pregunta_3 character varying(255),
    respuesta_3 character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    two_factor_secret text,
    two_factor_recovery_codes text,
    two_factor_confirmed_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: dictamen id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dictamen ALTER COLUMN id SET DEFAULT nextval('public.dictamen_id_seq'::regclass);


--
-- Name: direccion id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.direccion ALTER COLUMN id SET DEFAULT nextval('public.direccion_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: funcionario id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.funcionario ALTER COLUMN id SET DEFAULT nextval('public.funcionario_id_seq'::regclass);


--
-- Name: guide_sequences id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.guide_sequences ALTER COLUMN id SET DEFAULT nextval('public.guide_sequences_id_seq'::regclass);


--
-- Name: imagen id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.imagen ALTER COLUMN id SET DEFAULT nextval('public.imagen_id_seq'::regclass);


--
-- Name: imagen_solicitud id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.imagen_solicitud ALTER COLUMN id SET DEFAULT nextval('public.imagen_solicitud_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: nomenclador_geografico id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nomenclador_geografico ALTER COLUMN id SET DEFAULT nextval('public.nomenclador_geografico_id_seq'::regclass);


--
-- Name: permissions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions ALTER COLUMN id SET DEFAULT nextval('public.permissions_id_seq'::regclass);


--
-- Name: persona id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona ALTER COLUMN id SET DEFAULT nextval('public.persona_id_seq'::regclass);


--
-- Name: persona_direccion id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona_direccion ALTER COLUMN id SET DEFAULT nextval('public.persona_direccion_id_seq'::regclass);


--
-- Name: persona_telefono id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona_telefono ALTER COLUMN id SET DEFAULT nextval('public.persona_telefono_id_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Name: registro_policial id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registro_policial ALTER COLUMN id SET DEFAULT nextval('public.registro_policial_id_seq'::regclass);


--
-- Name: registro_solicitud id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registro_solicitud ALTER COLUMN id SET DEFAULT nextval('public.registro_solicitud_id_seq'::regclass);


--
-- Name: registro_unico id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registro_unico ALTER COLUMN id SET DEFAULT nextval('public.registro_unico_id_seq'::regclass);


--
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- Name: solicitud id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud ALTER COLUMN id SET DEFAULT nextval('public.solicitud_id_seq'::regclass);


--
-- Name: solicitud_administrativa id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_administrativa ALTER COLUMN id SET DEFAULT nextval('public.solicitud_administrativa_id_seq'::regclass);


--
-- Name: telefono id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.telefono ALTER COLUMN id SET DEFAULT nextval('public.telefono_id_seq'::regclass);


--
-- Name: traza_acceso id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.traza_acceso ALTER COLUMN id SET DEFAULT nextval('public.traza_acceso_id_seq'::regclass);


--
-- Name: unidad_administrativa id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.unidad_administrativa ALTER COLUMN id SET DEFAULT nextval('public.unidad_administrativa_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: dictamen dictamen_guia_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dictamen
    ADD CONSTRAINT dictamen_guia_unique UNIQUE (guia);


--
-- Name: dictamen dictamen_numero_carpeta_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dictamen
    ADD CONSTRAINT dictamen_numero_carpeta_unique UNIQUE (numero_carpeta);


--
-- Name: dictamen dictamen_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dictamen
    ADD CONSTRAINT dictamen_pkey PRIMARY KEY (id);


--
-- Name: direccion direccion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.direccion
    ADD CONSTRAINT direccion_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: funcionario funcionario_credencial_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.funcionario
    ADD CONSTRAINT funcionario_credencial_unique UNIQUE (credencial);


--
-- Name: funcionario funcionario_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.funcionario
    ADD CONSTRAINT funcionario_pkey PRIMARY KEY (id);


--
-- Name: guide_sequences guide_sequences_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.guide_sequences
    ADD CONSTRAINT guide_sequences_pkey PRIMARY KEY (id);


--
-- Name: guide_sequences guide_sequences_type_year_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.guide_sequences
    ADD CONSTRAINT guide_sequences_type_year_unique UNIQUE (type, year);


--
-- Name: imagen imagen_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.imagen
    ADD CONSTRAINT imagen_pkey PRIMARY KEY (id);


--
-- Name: imagen_solicitud imagen_solicitud_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.imagen_solicitud
    ADD CONSTRAINT imagen_solicitud_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: model_has_permissions model_has_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_pkey PRIMARY KEY (permission_id, model_id, model_type);


--
-- Name: model_has_roles model_has_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_pkey PRIMARY KEY (role_id, model_id, model_type);


--
-- Name: nomenclador_geografico nomenclador_geografico_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nomenclador_geografico
    ADD CONSTRAINT nomenclador_geografico_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: permissions permissions_name_guard_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_name_guard_name_unique UNIQUE (name, guard_name);


--
-- Name: permissions permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id);


--
-- Name: persona persona_cedula_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona
    ADD CONSTRAINT persona_cedula_unique UNIQUE (cedula);


--
-- Name: persona_direccion persona_direccion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona_direccion
    ADD CONSTRAINT persona_direccion_pkey PRIMARY KEY (id);


--
-- Name: persona persona_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona
    ADD CONSTRAINT persona_pkey PRIMARY KEY (id);


--
-- Name: persona_telefono persona_telefono_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona_telefono
    ADD CONSTRAINT persona_telefono_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: registro_policial registro_policial_guia_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registro_policial
    ADD CONSTRAINT registro_policial_guia_unique UNIQUE (guia);


--
-- Name: registro_policial registro_policial_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registro_policial
    ADD CONSTRAINT registro_policial_pkey PRIMARY KEY (id);


--
-- Name: registro_solicitud registro_solicitud_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registro_solicitud
    ADD CONSTRAINT registro_solicitud_pkey PRIMARY KEY (id);


--
-- Name: registro_unico registro_unico_guia_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registro_unico
    ADD CONSTRAINT registro_unico_guia_unique UNIQUE (guia);


--
-- Name: registro_unico registro_unico_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registro_unico
    ADD CONSTRAINT registro_unico_pkey PRIMARY KEY (id);


--
-- Name: role_has_permissions role_has_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_pkey PRIMARY KEY (permission_id, role_id);


--
-- Name: roles roles_name_guard_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_name_guard_name_unique UNIQUE (name, guard_name);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: solicitud_administrativa solicitud_administrativa_guia_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_administrativa
    ADD CONSTRAINT solicitud_administrativa_guia_unique UNIQUE (guia);


--
-- Name: solicitud_administrativa solicitud_administrativa_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_administrativa
    ADD CONSTRAINT solicitud_administrativa_pkey PRIMARY KEY (id);


--
-- Name: solicitud solicitud_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud
    ADD CONSTRAINT solicitud_pkey PRIMARY KEY (id);


--
-- Name: telefono telefono_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.telefono
    ADD CONSTRAINT telefono_pkey PRIMARY KEY (id);


--
-- Name: traza_acceso traza_acceso_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.traza_acceso
    ADD CONSTRAINT traza_acceso_pkey PRIMARY KEY (id);


--
-- Name: unidad_administrativa unidad_administrativa_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.unidad_administrativa
    ADD CONSTRAINT unidad_administrativa_pkey PRIMARY KEY (id);


--
-- Name: users users_funcionario_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_funcionario_id_unique UNIQUE (funcionario_id);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: model_has_permissions_model_id_model_type_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX model_has_permissions_model_id_model_type_index ON public.model_has_permissions USING btree (model_id, model_type);


--
-- Name: model_has_roles_model_id_model_type_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX model_has_roles_model_id_model_type_index ON public.model_has_roles USING btree (model_id, model_type);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: dictamen dictamen_solicitud_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.dictamen
    ADD CONSTRAINT dictamen_solicitud_id_foreign FOREIGN KEY (solicitud_id) REFERENCES public.solicitud(id) ON DELETE CASCADE;


--
-- Name: funcionario funcionario_persona_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.funcionario
    ADD CONSTRAINT funcionario_persona_id_foreign FOREIGN KEY (persona_id) REFERENCES public.persona(id) ON DELETE CASCADE;


--
-- Name: funcionario funcionario_unidad_administrativa_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.funcionario
    ADD CONSTRAINT funcionario_unidad_administrativa_id_foreign FOREIGN KEY (unidad_administrativa_id) REFERENCES public.unidad_administrativa(id) ON DELETE SET NULL;


--
-- Name: imagen_solicitud imagen_solicitud_imagen_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.imagen_solicitud
    ADD CONSTRAINT imagen_solicitud_imagen_id_foreign FOREIGN KEY (imagen_id) REFERENCES public.imagen(id) ON DELETE CASCADE;


--
-- Name: imagen_solicitud imagen_solicitud_solicitud_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.imagen_solicitud
    ADD CONSTRAINT imagen_solicitud_solicitud_id_foreign FOREIGN KEY (solicitud_id) REFERENCES public.solicitud(id) ON DELETE CASCADE;


--
-- Name: model_has_permissions model_has_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- Name: model_has_roles model_has_roles_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: persona_direccion persona_direccion_direccion_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona_direccion
    ADD CONSTRAINT persona_direccion_direccion_id_foreign FOREIGN KEY (direccion_id) REFERENCES public.direccion(id) ON DELETE CASCADE;


--
-- Name: persona_direccion persona_direccion_persona_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona_direccion
    ADD CONSTRAINT persona_direccion_persona_id_foreign FOREIGN KEY (persona_id) REFERENCES public.persona(id) ON DELETE CASCADE;


--
-- Name: persona persona_imagen_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona
    ADD CONSTRAINT persona_imagen_id_foreign FOREIGN KEY (imagen_id) REFERENCES public.imagen(id) ON DELETE SET NULL;


--
-- Name: persona_telefono persona_telefono_persona_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona_telefono
    ADD CONSTRAINT persona_telefono_persona_id_foreign FOREIGN KEY (persona_id) REFERENCES public.persona(id) ON DELETE CASCADE;


--
-- Name: persona_telefono persona_telefono_telefono_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona_telefono
    ADD CONSTRAINT persona_telefono_telefono_id_foreign FOREIGN KEY (telefono_id) REFERENCES public.telefono(id) ON DELETE CASCADE;


--
-- Name: registro_policial registro_policial_solicitud_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registro_policial
    ADD CONSTRAINT registro_policial_solicitud_id_foreign FOREIGN KEY (solicitud_id) REFERENCES public.solicitud(id) ON DELETE CASCADE;


--
-- Name: registro_policial registro_policial_verificadopor_persona_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registro_policial
    ADD CONSTRAINT registro_policial_verificadopor_persona_id_foreign FOREIGN KEY (verificadopor_persona_id) REFERENCES public.persona(id) ON DELETE SET NULL;


--
-- Name: registro_solicitud registro_solicitud_solicitud_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registro_solicitud
    ADD CONSTRAINT registro_solicitud_solicitud_id_foreign FOREIGN KEY (solicitud_id) REFERENCES public.solicitud(id) ON DELETE CASCADE;


--
-- Name: registro_unico registro_unico_solicitud_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.registro_unico
    ADD CONSTRAINT registro_unico_solicitud_id_foreign FOREIGN KEY (solicitud_id) REFERENCES public.solicitud(id) ON DELETE CASCADE;


--
-- Name: role_has_permissions role_has_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- Name: role_has_permissions role_has_permissions_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: solicitud solicitud_abogado_funcionario_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud
    ADD CONSTRAINT solicitud_abogado_funcionario_id_foreign FOREIGN KEY (abogado_funcionario_id) REFERENCES public.persona(id) ON DELETE CASCADE;


--
-- Name: solicitud_administrativa solicitud_administrativa_solicitud_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_administrativa
    ADD CONSTRAINT solicitud_administrativa_solicitud_id_foreign FOREIGN KEY (solicitud_id) REFERENCES public.solicitud(id) ON DELETE CASCADE;


--
-- Name: solicitud solicitud_apoderado_persona_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud
    ADD CONSTRAINT solicitud_apoderado_persona_id_foreign FOREIGN KEY (apoderado_persona_id) REFERENCES public.persona(id) ON DELETE CASCADE;


--
-- Name: solicitud solicitud_registrador_funcionario_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud
    ADD CONSTRAINT solicitud_registrador_funcionario_id_foreign FOREIGN KEY (registrador_funcionario_id) REFERENCES public.funcionario(id) ON DELETE CASCADE;


--
-- Name: solicitud solicitud_solicitante_persona_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud
    ADD CONSTRAINT solicitud_solicitante_persona_id_foreign FOREIGN KEY (solicitante_persona_id) REFERENCES public.persona(id) ON DELETE CASCADE;


--
-- Name: traza_acceso traza_acceso_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.traza_acceso
    ADD CONSTRAINT traza_acceso_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: users users_funcionario_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_funcionario_id_foreign FOREIGN KEY (funcionario_id) REFERENCES public.funcionario(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

