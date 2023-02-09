--
-- PostgreSQL database dump
--

-- Dumped from database version 15.1
-- Dumped by pg_dump version 15.1

-- Started on 2023-02-09 10:08:37 +01

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

--
-- TOC entry 858 (class 1247 OID 65612)
-- Name: ENUM; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE public."ENUM" AS ENUM (
    'reserved',
    'free'
);


ALTER TYPE public."ENUM" OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 217 (class 1259 OID 65562)
-- Name: seats; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.seats (
    id integer NOT NULL,
    reservation_id integer,
    num integer
);


ALTER TABLE public.seats OWNER TO postgres;

--
-- TOC entry 216 (class 1259 OID 65561)
-- Name: Places_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.seats ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public."Places_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 221 (class 1259 OID 65584)
-- Name: films; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.films (
    id integer NOT NULL,
    date date,
    "time" text,
    hall_id integer,
    title text
);


ALTER TABLE public.films OWNER TO postgres;

--
-- TOC entry 220 (class 1259 OID 65583)
-- Name: films_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.films ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.films_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 219 (class 1259 OID 65578)
-- Name: halls; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.halls (
    id integer NOT NULL,
    capacity integer,
    name text
);


ALTER TABLE public.halls OWNER TO postgres;

--
-- TOC entry 218 (class 1259 OID 65577)
-- Name: halls_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.halls ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.halls_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 215 (class 1259 OID 65552)
-- Name: reservations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reservations (
    id integer NOT NULL,
    user_key text NOT NULL,
    created_at timestamp with time zone,
    film_id integer
);


ALTER TABLE public.reservations OWNER TO postgres;

--
-- TOC entry 214 (class 1259 OID 65551)
-- Name: reservations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.reservations ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.reservations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 223 (class 1259 OID 65599)
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id integer NOT NULL,
    fname text,
    lname text,
    email text,
    role integer,
    key text,
    password text
);


ALTER TABLE public.users OWNER TO postgres;

--
-- TOC entry 222 (class 1259 OID 65598)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.users ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 3629 (class 0 OID 65584)
-- Dependencies: 221
-- Data for Name: films; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.films (id, date, "time", hall_id, title) FROM stdin;
23	2023-02-14	09:00	6	One Piece
24	2023-02-18	22:00	6	Bleach
25	2023-02-28	23:00	13	Jujutsu kaisen
26	2023-02-09	19:00	14	Kimetsu no yaiba
\.


--
-- TOC entry 3627 (class 0 OID 65578)
-- Dependencies: 219
-- Data for Name: halls; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.halls (id, capacity, name) FROM stdin;
6	28	Salle 7
11	25	Salle 2
13	27	Salle 5
14	36	Salle 3
16	50	Salle 99
17	40	Salle 44
\.


--
-- TOC entry 3623 (class 0 OID 65552)
-- Dependencies: 215
-- Data for Name: reservations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.reservations (id, user_key, created_at, film_id) FROM stdin;
33	E4581-83E6F-1B7C1-40551	\N	24
35	12243-C7850-2B2BC-A0EA5	\N	24
36	85602-B8A89-BA446-60F63	\N	24
37	FB2C2-A52B5-345CB-9F73B	\N	24
38	85602-B8A89-BA446-60F63	\N	24
39	9972C-7CF47-2E1FB-CC841	\N	23
40	85602-B8A89-BA446-60F63	\N	23
41	09C25-D283C-385A1-BD4C0	\N	26
42	3B786-EA7C4-B2570-EAB8C	\N	26
\.


--
-- TOC entry 3625 (class 0 OID 65562)
-- Dependencies: 217
-- Data for Name: seats; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.seats (id, reservation_id, num) FROM stdin;
8	33	8
9	33	9
10	33	10
14	38	6
15	38	17
16	38	28
17	40	1
18	40	8
19	40	9
20	42	20
21	42	21
22	42	22
\.


--
-- TOC entry 3631 (class 0 OID 65599)
-- Dependencies: 223
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, fname, lname, email, role, key, password) FROM stdin;
2	Ahmed	Ennaime	ahmedennaime20@gmail.com	0		admin
9	Mohammed	Moutrafir	mousta@gmail.com	1	E957B-E5C91-6432F-3EB36	\N
10	Abdelali	Khalif	khalif@gmail.com	1	E4581-83E6F-1B7C1-40551	\N
12	Samir	Ait el kadi	samir@gmail.com	1	87F64-3F085-76CEF-97FEC	\N
13	\N	\N	\N	1	12243-C7850-2B2BC-A0EA5	\N
14	Moudir	Med	moudir@gmail.com	1	85602-B8A89-BA446-60F63	\N
15	\N	\N	\N	1	FB2C2-A52B5-345CB-9F73B	\N
16	\N	\N	\N	1	9972C-7CF47-2E1FB-CC841	\N
17	\N	\N	\N	1	09C25-D283C-385A1-BD4C0	\N
18	Hamza	Essouli	hamzaessouli@gmail.com	1	3B786-EA7C4-B2570-EAB8C	\N
\.


--
-- TOC entry 3637 (class 0 OID 0)
-- Dependencies: 216
-- Name: Places_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public."Places_id_seq"', 22, true);


--
-- TOC entry 3638 (class 0 OID 0)
-- Dependencies: 220
-- Name: films_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.films_id_seq', 26, true);


--
-- TOC entry 3639 (class 0 OID 0)
-- Dependencies: 218
-- Name: halls_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.halls_id_seq', 17, true);


--
-- TOC entry 3640 (class 0 OID 0)
-- Dependencies: 214
-- Name: reservations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.reservations_id_seq', 42, true);


--
-- TOC entry 3641 (class 0 OID 0)
-- Dependencies: 222
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 18, true);


--
-- TOC entry 3465 (class 2606 OID 65566)
-- Name: seats Places_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seats
    ADD CONSTRAINT "Places_pkey" PRIMARY KEY (id);


--
-- TOC entry 3471 (class 2606 OID 73757)
-- Name: users email; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT email UNIQUE (email) INCLUDE (email);


--
-- TOC entry 3469 (class 2606 OID 65590)
-- Name: films films_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films
    ADD CONSTRAINT films_pkey PRIMARY KEY (id);


--
-- TOC entry 3467 (class 2606 OID 65582)
-- Name: halls halls_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.halls
    ADD CONSTRAINT halls_pkey PRIMARY KEY (id);


--
-- TOC entry 3463 (class 2606 OID 65558)
-- Name: reservations reservations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_pkey PRIMARY KEY (id);


--
-- TOC entry 3473 (class 2606 OID 73750)
-- Name: users user_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT user_key UNIQUE (key) INCLUDE (key);


--
-- TOC entry 3475 (class 2606 OID 65605)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 3476 (class 2606 OID 90126)
-- Name: reservations film_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT film_id FOREIGN KEY (film_id) REFERENCES public.films(id);


--
-- TOC entry 3477 (class 2606 OID 73751)
-- Name: reservations fk_user_key; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT fk_user_key FOREIGN KEY (user_key) REFERENCES public.users(key) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 3479 (class 2606 OID 65591)
-- Name: films hall_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.films
    ADD CONSTRAINT hall_id FOREIGN KEY (hall_id) REFERENCES public.halls(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 3478 (class 2606 OID 65567)
-- Name: seats reservation_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.seats
    ADD CONSTRAINT reservation_id FOREIGN KEY (reservation_id) REFERENCES public.reservations(id) ON UPDATE CASCADE ON DELETE CASCADE;


-- Completed on 2023-02-09 10:08:38 +01

--
-- PostgreSQL database dump complete
--

