#include <sys/wait.h>
#include <unistd.h>
#include <stdlib.h>
#include <stdio.h>
#include <string.h>


#include "tshtest.h"
tsh_get_it out;  // For return port prep
int sd, status;
struct in_addr addr ;

#define MATRIXSCRIPT "\
#/bin/bash \n\
chmod 755 matrixscript.sh \n\
"

#define TSHScript "\
#/bin/bash \n\
touch *.c \n\
make \n\
./tsh $1 & \n\
"

u_short bind_socket2(int sd, u_short port)
{  
   struct sockaddr_in self ;
   int self_len ;               
                                /* bind socket to any port */
   bzero((char *) &self, sizeof(self)) ;
   self.sin_family = AF_INET ;
   self.sin_addr.s_addr = htonl(INADDR_ANY) ;
   self.sin_port = (port) ;  // Removed htons() call. JYS
   if (bind(sd, (struct sockaddr *)&self, sizeof(self)) == -1)
      return 0 ;                
                                /* determine bound port */
   bzero((char *) &self, sizeof(self)) ;
   self_len = sizeof(self) ;
   if (getsockname(sd, (struct sockaddr *)&self, &self_len) == -1)
      return 0 ;
   if (listen(sd, 5) == -1)
      return 0 ;
   
   return self.sin_port ;       /* return port bound */
}



const char *myarg = NULL;

int main(int argc, char **args) {
//arg[0] is the executable
//args[1] = port number
//args [2] path of executable
//args [3] port number
//printf("arg[1] %s arg[2] %s arg[3] %s\n", args[1], args[2], args[3]);

char matrixscript[80];
char tshscript[80];
strcpy(matrixscript, "./matrixscript.sh ");
strcat(matrixscript, args[1]);
strcat(matrixscript, " ");
strcat(matrixscript, args[2]);
strcat(tshscript, args[1]);

if(strcmp(args[2], "./tsh") == 0) {
strcpy(tshscript, "./tshscript.sh ");
}


//tshport

if(strcmp(args[2],"../apps/matrix")==0) {

system(matrixscript);
}




/*        static void (*op_func[])() =
        {
                OpPut, OpGet, OpGet, OpPurge, OpShell, OpExit
    } ;

        u_short this_op ;

        if (argc < 2)
    {  
       printf("Usage : %s TS-port\n", argv[0]) ;
       exit(1) ;
    }
        // Check the availability of return Ret-port
        out.host = gethostid() ;        // Get return hostid (localhost)
        if ((sd = get_socket()) == -1)
    {  
       perror("\nReturn sock failure::get_socket. Try a different port.\n") ;
       exit(1);
    }

        if (!(out.port = bind_socket(sd, 0)))
    {  
       perror("\nReturn sock failure::bind_socket. No port available\n") ;
       exit(1);
    }
        addr.s_addr = out.host;
                                /* print return sock info */
/*        printf("\nReturn Port Info:\n") ;
        printf("\nhost : %s", inet_ntoa(addr)) ;
        printf("\nHOST (%d)", out.host);
        printf("\nport : %d\n", out.port) ;
        close(sd);  // To be rebuilt in GET
        getchar();
        while (TRUE)
    {
       this_op = drawMenu() + TSH_OP_MIN - 1 ;
       if (this_op >= TSH_OP_MIN && this_op <= TSH_OP_MAX)
           {
                   this_op = htons(this_op) ;
                   tshsock = connectTsh(atoi(argv[1])) ;
                   // Send this_op to TSH
                   if (!writen(tshsock, (char *)&this_op, sizeof(this_op)))
                        {
                           perror("main::writen\n") ;
                           exit(1) ;
                        }
                        printf("sent tsh op %d \n",this_op);
                   // Response processing
                   (*op_func[ntohs(this_op) - TSH_OP_MIN])() ;
                   close(sd); // Close return sock
                   close(tshsock) ;
           }                    /* validate operation & process */
       return 0 ;
    }

void OpPut()
{  
   tsh_put_it out ;
   tsh_put_ot in ;
   int tmp ;
   char *buff,*st ;
   
   status=system("clear") ;
   printf("TSH_OP_PUT") ;
   printf("\n----------\n") ;   
                                /* obtain tuple name, priority, length, */
   printf("\nEnter tuple name : ") ; /* and the tuple */
   status=scanf("%s", out.name) ;
   printf("Enter priority : ") ;
   status=scanf("%d", &tmp) ;
   out.priority = (u_short)tmp ;
   printf("Enter length : ") ;
   status=scanf("%d", &out.length) ;
   getchar() ;
   printf("Enter tuple : ") ;
   buff = (char *)malloc(out.length) ;
   st=fgets(buff, out.length, stdin) ;
                                /* print data sent to TSH */
   printf("\n\nTo TSH :\n") ;
   printf("\nname : %s", out.name) ;
   printf("\npriority : %d", out.priority) ;
   printf("\nlength : %d", out.length) ;
   printf("\ntuple : %s\n", buff) ;
   
   out.priority = htons(out.priority) ;
   out.length = htonl(out.length) ;
                                /* send data to TSH */
   if (!writen(tshsock, (char *)&out, sizeof(out)))
    {  
       perror("\nOpPut::writen\n") ;
       getchar() ;
       free(buff) ;
       return ;
    }                           
                                /* send tuple to TSH */
   if (!writen(tshsock, buff, ntohl(out.length)))
    {  
       perror("\nOpPut::writen\n") ;
       getchar() ;
       free(buff) ;
       return ;
    }                           
                                /* read result */
   if (!readn(tshsock, (char *)&in, sizeof(in)))
    {  
       perror("\nOpPut::readn\n") ;
       getchar() ;
       return ;
    }                           
                                /* print result from TSH */
   printf("\n\nFrom TSH :\n") ;
   printf("\nstatus : %d", ntohs(in.status)) ;
   printf("\nerror : %d\n", ntohs(in.error)) ;
   getchar() ;
}



