CC=gcc
CFLAGS=-g  -Wall -std=c99 -D_GNU_SOURCE

testMot : testMot.o mot.o
	$(CC) $(CFLAGS) -o $@ $+

.h.c:
	@echo regle de suffixe : .h modifie donne .c modifie
	touch $*.c

.c.o:
	@echo debut compil c sans edition de liens de $<
	$(CC) $(CFLAGS) -c $<
	@echo fin compil de $<

.c:
	@echo debut compil c complete de $<
	$(CC) $(CFLAGS) -o $* $<
	@echo fin compil de $< en $*