from bs4 import BeautifulSoup
from html_table_extractor.extractor import Extractor
import numpy as np
import numpy as np; np.random.seed(0)
import matplotlib.pyplot as plt
import seaborn as sns; sns.set_theme()


with open("C:\crossreactivity\sias_uncut.html", 'r') as f: 
    sias_scam = f.read() 
    soup = BeautifulSoup(sias_scam, 'lxml') # Parse the HTML as a string

all_tables = soup.find_all('table')


def scores(indx):
    table = all_tables[indx] # Grab the first table
    extractor = Extractor(table)
    extractor.parse()
    sias_list = extractor.return_list()
    
    sias_list = sias_list[:-3]
    sias_len = len(sias_list)
    sias_names = sias_list[sias_len - 1]
    sias_names = sias_names[1:]

    num_item = len(sias_names)

    sias_final =  [[0] * num_item for _ in range(num_item)]

    for i in range(sias_len-1):
        row = sias_list[i]
        row = row[1:]
        for j in range(len(row)):
            sias_final[i][j] = row[j]  

    return sias_final

identity = scores(1)
similarity = scores(4)


def percent(matrix):
    num_final = [[0] * len(matrix) for _ in range(len(matrix))]
    for i in range(len(matrix)):
        for j in range(i+1):
            num = matrix[i][j].strip("%")
            num = float(num)
            num_final[i][j] = num
    return num_final

iden_final = percent(identity)
simi_final = percent(similarity)

arisc_final = [[0] * len(identity) for _ in range(len(identity))]

for i in range(len(iden_final)):
        for j in range(i+1):
            ide = iden_final[i][j]
            sim = simi_final[i][j]
            avg = (ide+sim)/2
            arisc_final[i][j] = avg

arisc_matrix = np.matrix(arisc_final)

ax = sns.heatmap(arisc_matrix, cmap= "BuPu")

plt.show()