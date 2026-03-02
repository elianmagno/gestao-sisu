--
-- PostgreSQL database dump
--

-- Dumped from database version 17.5 (Debian 17.5-1.pgdg120+1)
-- Dumped by pg_dump version 17.5 (Debian 17.5-1.pgdg120+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
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
-- Name: candidatos; Type: TABLE; Schema: public; Owner: sisu_app
--

CREATE TABLE public.candidatos (
    id integer NOT NULL,
    nome text NOT NULL,
    cpf text NOT NULL,
    data_nascimento date NOT NULL,
    categoria text NOT NULL,
    curso_id integer NOT NULL,
    edicao_id integer NOT NULL,
    nota numeric(6,2) NOT NULL,
    CONSTRAINT candidatos_categoria_check CHECK ((categoria = ANY (ARRAY['Ampla Concorrência'::text, 'PPI - Pública - Baixa Renda'::text, 'Pública - Baixa Renda'::text, 'PPI - Pública'::text, 'Pública'::text, 'Deficientes'::text]))),
    CONSTRAINT candidatos_nota_check CHECK (((nota >= (0)::numeric) AND (nota <= (1000)::numeric)))
);


ALTER TABLE public.candidatos OWNER TO sisu_app;

--
-- Name: candidatos_id_seq; Type: SEQUENCE; Schema: public; Owner: sisu_app
--

CREATE SEQUENCE public.candidatos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.candidatos_id_seq OWNER TO sisu_app;

--
-- Name: candidatos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sisu_app
--

ALTER SEQUENCE public.candidatos_id_seq OWNED BY public.candidatos.id;


--
-- Name: curso_edicao; Type: TABLE; Schema: public; Owner: sisu_app
--

CREATE TABLE public.curso_edicao (
    id integer NOT NULL,
    curso_id integer NOT NULL,
    edicao_id integer NOT NULL,
    vagas_ac integer NOT NULL,
    vagas_ppi_br integer NOT NULL,
    vagas_publica_br integer NOT NULL,
    vagas_ppi_publica integer NOT NULL,
    vagas_publica integer NOT NULL,
    vagas_deficientes integer NOT NULL,
    CONSTRAINT curso_edicao_vagas_ac_check CHECK ((vagas_ac >= 0)),
    CONSTRAINT curso_edicao_vagas_deficientes_check CHECK ((vagas_deficientes >= 0)),
    CONSTRAINT curso_edicao_vagas_ppi_br_check CHECK ((vagas_ppi_br >= 0)),
    CONSTRAINT curso_edicao_vagas_ppi_publica_check CHECK ((vagas_ppi_publica >= 0)),
    CONSTRAINT curso_edicao_vagas_publica_br_check CHECK ((vagas_publica_br >= 0)),
    CONSTRAINT curso_edicao_vagas_publica_check CHECK ((vagas_publica >= 0))
);


ALTER TABLE public.curso_edicao OWNER TO sisu_app;

--
-- Name: curso_edicao_id_seq; Type: SEQUENCE; Schema: public; Owner: sisu_app
--

CREATE SEQUENCE public.curso_edicao_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.curso_edicao_id_seq OWNER TO sisu_app;

--
-- Name: curso_edicao_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sisu_app
--

ALTER SEQUENCE public.curso_edicao_id_seq OWNED BY public.curso_edicao.id;


--
-- Name: cursos; Type: TABLE; Schema: public; Owner: sisu_app
--

CREATE TABLE public.cursos (
    id integer NOT NULL,
    nome text NOT NULL
);


ALTER TABLE public.cursos OWNER TO sisu_app;

--
-- Name: cursos_id_seq; Type: SEQUENCE; Schema: public; Owner: sisu_app
--

CREATE SEQUENCE public.cursos_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.cursos_id_seq OWNER TO sisu_app;

--
-- Name: cursos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sisu_app
--

ALTER SEQUENCE public.cursos_id_seq OWNED BY public.cursos.id;


--
-- Name: edicoes; Type: TABLE; Schema: public; Owner: sisu_app
--

CREATE TABLE public.edicoes (
    id integer NOT NULL,
    nome text NOT NULL
);


ALTER TABLE public.edicoes OWNER TO sisu_app;

--
-- Name: edicoes_id_seq; Type: SEQUENCE; Schema: public; Owner: sisu_app
--

CREATE SEQUENCE public.edicoes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.edicoes_id_seq OWNER TO sisu_app;

--
-- Name: edicoes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: sisu_app
--

ALTER SEQUENCE public.edicoes_id_seq OWNED BY public.edicoes.id;


--
-- Name: candidatos id; Type: DEFAULT; Schema: public; Owner: sisu_app
--

ALTER TABLE ONLY public.candidatos ALTER COLUMN id SET DEFAULT nextval('public.candidatos_id_seq'::regclass);


--
-- Name: curso_edicao id; Type: DEFAULT; Schema: public; Owner: sisu_app
--

ALTER TABLE ONLY public.curso_edicao ALTER COLUMN id SET DEFAULT nextval('public.curso_edicao_id_seq'::regclass);


--
-- Name: cursos id; Type: DEFAULT; Schema: public; Owner: sisu_app
--

ALTER TABLE ONLY public.cursos ALTER COLUMN id SET DEFAULT nextval('public.cursos_id_seq'::regclass);


--
-- Name: edicoes id; Type: DEFAULT; Schema: public; Owner: sisu_app
--

ALTER TABLE ONLY public.edicoes ALTER COLUMN id SET DEFAULT nextval('public.edicoes_id_seq'::regclass);


--
-- Name: candidatos candidatos_cpf_edicao_id_key; Type: CONSTRAINT; Schema: public; Owner: sisu_app
--

ALTER TABLE ONLY public.candidatos
    ADD CONSTRAINT candidatos_cpf_edicao_id_key UNIQUE (cpf, edicao_id);


--
-- Name: candidatos candidatos_pkey; Type: CONSTRAINT; Schema: public; Owner: sisu_app
--

ALTER TABLE ONLY public.candidatos
    ADD CONSTRAINT candidatos_pkey PRIMARY KEY (id);


--
-- Name: curso_edicao curso_edicao_curso_id_edicao_id_key; Type: CONSTRAINT; Schema: public; Owner: sisu_app
--

ALTER TABLE ONLY public.curso_edicao
    ADD CONSTRAINT curso_edicao_curso_id_edicao_id_key UNIQUE (curso_id, edicao_id);


--
-- Name: curso_edicao curso_edicao_pkey; Type: CONSTRAINT; Schema: public; Owner: sisu_app
--

ALTER TABLE ONLY public.curso_edicao
    ADD CONSTRAINT curso_edicao_pkey PRIMARY KEY (id);


--
-- Name: cursos cursos_pkey; Type: CONSTRAINT; Schema: public; Owner: sisu_app
--

ALTER TABLE ONLY public.cursos
    ADD CONSTRAINT cursos_pkey PRIMARY KEY (id);


--
-- Name: edicoes edicoes_pkey; Type: CONSTRAINT; Schema: public; Owner: sisu_app
--

ALTER TABLE ONLY public.edicoes
    ADD CONSTRAINT edicoes_pkey PRIMARY KEY (id);


--
-- Name: candidatos candidatos_curso_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sisu_app
--

ALTER TABLE ONLY public.candidatos
    ADD CONSTRAINT candidatos_curso_id_fkey FOREIGN KEY (curso_id) REFERENCES public.cursos(id);


--
-- Name: candidatos candidatos_edicao_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sisu_app
--

ALTER TABLE ONLY public.candidatos
    ADD CONSTRAINT candidatos_edicao_id_fkey FOREIGN KEY (edicao_id) REFERENCES public.edicoes(id);


--
-- Name: curso_edicao curso_edicao_curso_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sisu_app
--

ALTER TABLE ONLY public.curso_edicao
    ADD CONSTRAINT curso_edicao_curso_id_fkey FOREIGN KEY (curso_id) REFERENCES public.cursos(id);


--
-- Name: curso_edicao curso_edicao_edicao_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: sisu_app
--

ALTER TABLE ONLY public.curso_edicao
    ADD CONSTRAINT curso_edicao_edicao_id_fkey FOREIGN KEY (edicao_id) REFERENCES public.edicoes(id);


--
-- PostgreSQL database dump complete
--

