#include <linux/linkage.h>
#include <linux/unistd.h>
#include <linux/errno.h>
#include <linux/kernel.h>
#include <linux/sched.h>
int g_pgid=-1;
EXPORT_SYMBOL(g_pgid);
asmlinkage long sys_add_pgid(int i)
{
	printk("add_pgid : %d\n",i);
	g_pgid = i;
}	
