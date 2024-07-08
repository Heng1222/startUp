import urllib.request as req
import csv
import bs4

def getInfoAndWriteCSV(url):
    request = req.Request(url,headers = {
        "User-Agent":"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.106 Safari/537.36"
    })
    with req.urlopen(request) as response:
        Data = response.read().decode("utf-8")   
        HTML = bs4.BeautifulSoup(Data,"lxml")
        context=HTML.find("div", {"class": "activitice_details"})
        try:
            title=context.find("h1",{"class":"theme"}).text    
        except:
            title=''
        ul=context.find("div",{"class":"activitce_infor02"}).find("ul")
        li_a=ul.find_all("li")
        link,startTime,endTime,host,phone,Email,location,fee,target,county,actType = ['無資料']*11
        for li in li_a:
            if(li.text.startswith("網站連結：")):
                link=li.find("a")['href']
            elif(li.text.startswith("開始時間：")):
                startTime=li.find("span").text
            elif(li.text.startswith("結束時間：")):
                endTime=li.find("span").text
            elif(li.text.startswith("主辦單位：")):
                host=li.find("span").text
            elif(li.text.startswith("連絡電話：")):
                phone=li.find("span").text
            elif(li.text.startswith("連絡Email：")):
                Email=li.find("span").text
            elif(li.text.startswith("地&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp點：")):
                location=li.find("span").text
            elif(li.text.startswith("費用性質：")):
                fee=li.find("span").text
            elif(li.text.startswith("參加對象：")):
                target=li.find("span").text
            county= "無資料" if(location.startswith("無資料")) else location[:3]
        actType=title[1:3]
        title=title[4:].strip()
        print(title,link,startTime,endTime,host,phone,Email,location,fee,target,county,actType,sep='\n',end='\n-------------------------\n')
        writer.writerow([title,link,startTime,endTime,host,phone,Email,location,fee,target,county,actType])        

def getPagelist(firstPageURL):
    pageURL=[firstPageURL]
    request = req.Request(firstPageURL,headers = {
        "User-Agent":"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.106 Safari/537.36"
    })
    with req.urlopen(request) as response:
        Data = response.read().decode("utf-8")
        HTML = bs4.BeautifulSoup(Data,"lxml")
        page=HTML.find("div",{"class":"pagenavi"})
        others=page.find_all('a')
        for other in others:
            other="https://sme.moeasmea.gov.tw/startup/modules/calendar/"+other['href']
            pageURL.append(other)

        return pageURL 

def getActivitiesURL(pagelist):
    activitiesURLs=[]
    for page in pageList:
        request = req.Request(page,headers = {
        "User-Agent":"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.106 Safari/537.36"
        })
        with req.urlopen(request) as response:
            Data = response.read().decode("utf-8")
            HTML = bs4.BeautifulSoup(Data,"lxml")
            posts=HTML.find_all("div",{"class":"post-module"})
            for post in posts:
                activitiesURL=post.find("a")["href"]
                activitiesURL="https://sme.moeasmea.gov.tw/startup/modules/calendar"+activitiesURL
                activitiesURLs.append(activitiesURL)
    return activitiesURLs



with open('activities.csv', 'w', newline='',encoding='utf-8-sig') as csvfile:
    writer = csv.writer(csvfile)
    writer.writerow(['活動名稱', '連結','開始時間','結束時間','主辦單位','連絡電話','聯絡Email','地點','費用','參加對象','縣市','類型'])#'圖片'、'期間限定'沒加 
    page1="https://sme.moeasmea.gov.tw/startup/modules/calendar/?keyword=&start_date=2023-08-30&end_date=2023-12-31&city_area=&type=&payType=&csrf_token=9a3f1400a18cd505ad68fe7aed41bb1a9da8b7fe"
    pageList=getPagelist(page1)
    activitesList=getActivitiesURL(pageList)
    for activity in activitesList:
        getInfoAndWriteCSV(activity)


        
