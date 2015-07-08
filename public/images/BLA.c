#include <graphics.h>
#include <math.h>
void BLA (int, int, int, int);
int main()
{
	
	int x1,y1,x2,y2;
	printf("Enter two end points:\n");
	scanf("%d %d %d %d",&x1,&y1,&x2,&y2);
	BLA(x1,y1,x2,y2);
	getch();
	return 0;
} //end main

void BLA(int x1 , int y1 , int x2 , int y2)
{
	int gd = DETECT,gm;
    initgraph(&gd,&gm,NULL);
	int x,y;
	int dx = fabs(x2 -x1 ), dy=fabs(y2 -y1);
	int pk, xEnd;
	pk=2*dy-dx;
	//determine which point to use as start, which as end
	if(x1 > x2 )
	{
		x = x2;
		y = y2;
		xEnd = x1;
	}
	else 
	{
		x = x1;
		y = y1;
		xEnd = x2;
	}
	putpixel(x,y,WHITE);
	
	while (x < xEnd)
	{
		x++;
		if(pk<0)
		pk=pk+2*dy;
		else
		{
			y++;
			pk= pk+2*dy-2*dx;
		}
	putpixel(x,y,WHITE);
	delay(100);
	}
}
